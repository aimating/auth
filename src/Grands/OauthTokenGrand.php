<?php

declare(strict_types=1);

namespace Aimating\Auth\Grands;
use Psr\Http\Message\ResponseInterface;
use Aimating\Oauth2\TokenAuthorizationServiceHandler;
use Aimating\Oauth2\Contract\AuthenticationInterface;
use Hyperf\Contract\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use League\OAuth2\Server\RequestTypes\AuthorizationRequest;
use Aimating\Oauth2\AuthorizeHanlder;
use Aimating\Oauth2\Contract\AuthenticatableInterface;
use Aimating\Oauth2\Contract\UserAuthentionFactoryInterface;
use Aimating\Oauth2\Entities\UserEntity;
use League\OAuth2\Server\Exception\OAuthServerException;
use Hyperf\Context\RequestContext;
class OauthTokenGrand implements \Aimating\Auth\Contract\GuardInterface
{


   private $user =null;

    private $resourceServer;

    private $resourceAdapter;

    public function __construct(
      private ContainerInterface $container,
      private TokenAuthorizationServiceHandler  $authServer,
      private AuthenticationInterface $sourceServer
    ) {

     

    }

    public function issueToken(ServerRequestInterface $request,ResponseInterface $response):ResponseInterface
    {
 
        return $this->authServer->handle($request,$response);
    }
  

    public function setUser(AuthenticatableInterface $user):self{
        $this->user = $user;
      return $this;
    }

    public function check(): bool
    {
        return $this->user !== null;
    }
    public function authenticate(ServerRequestInterface $request):ServerRequestInterface
    {
      try{
        $user =  $this->sourceServer->authenticate($request);
        if($user === null) throw new \Aimating\Auth\Exceptions\AuthExceptionFaild('access denied',403);
        //
        $this->setUser($user);
         $request = $request->withAttribute('user', $user);
         RequestContext::set($request);
      }catch(OAuthServerException $e) {
        throw new \Aimating\Auth\Exceptions\AuthExceptionFaild('access denied',401);
      }
  
      return $request;
    }

    public function getUser(): ?AuthenticatableInterface
    {
      return $this->user;
    }

    public function logout(): void
    {
        $this->user = null;
    }

    public function login($username,$password):AuthenticatableInterface
    {
        $model =$this->container->make(\Aimating\Oauth2\Contract\UserProviderInterface::class);
        $entity = $model->getEntityByUserCredentials($username,$password);
        if($entity === null) throw new \Aimating\Auth\Exceptions\AuthExceptionFaild('access denied',403);
        
         /**
     * [
                    'oauth_user_id'         => $userId,
                    'oauth_client_id'       => $clientId,
                    'oauth_access_token_id' => $result->getAttribute('oauth_access_token_id', null),
                    'oauth_scopes'          => $result->getAttribute('oauth_scopes', null),
                ]
     */
        $user = $this->container->get(UserAuthentionFactoryInterface::class)->createRedentials([
            'username' => $entity->username,
            'oauth_user_id' => (string)$entity->id

        ]);

        if($entity->clients && $entity->clients->id) {
            $user->setClientId((string)$entity->clients->id);
            $user->redirect_uri  = $entity->clients->redirect_uri;
        }
     
        $this->setUser($user);
        return $user;
    }

   
    public function authorize(ServerRequestInterface $request,ResponseInterface $response):ResponseInterface
    {
           $authRequest = $this->authServer->getAuthorizationServer()->validateAuthorizationRequest( $request);
        
            $user = $request->getAttribute('user');
      
            // The user is authenticated:
            if ($user) {
                $authRequest->setUser(new UserEntity($user->getUserId()));
    
                // This assumes all clients are trusted, but you could
                // handle consent here, or within the next middleware
                // as needed.
                $authRequest->setAuthorizationApproved(true);
        
                return $this->authServer->getAuthorizationServer()->completeAuthorizationRequest($authRequest, $response);
            }

            return $response->withStatus(403,'access denied');
    }
}   
