<?php

declare(strict_types=1);

namespace Aimating\Auth\Middlewares;
use Psr\Http\Server\MiddlewareInterface;
use Aimating\Auth\Contract\AuthManagerInterface;
use Aimating\Auth\Exceptions\AuthExceptionFaild;
use Psr\Http\Message\ResponseInterface;
use Hyperf\Context\ApplicationContext;
use Psr\Http\Message\ResponseFactoryInterface;
use Hyperf\Context\Context as HyperfContext;    

class AuthenticationMiddleware implements MiddlewareInterface
{

    public static $exPathUri = [
        'auth'
    ];

    public function __construct(private AuthManagerInterface $authManager) {

    }

    public function process(\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Server\RequestHandlerInterface $handler): ResponseInterface
    {
        $path = trim($request->getUri()->getPath(),'/');
        
        foreach (self::$exPathUri as $uri) {
            if(str_starts_with($path,$uri)) {
                return $handler->handle($request);
            }
        }
       
        try{
            $request = $this->authManager->guard()->authenticate($request);
         
            return $handler->handle($request);
        }catch(AuthExceptionFaild $e) {
            return $this->createResponse($request);
        }
       
            
       
        
    //    return $this->response;
    }

     private function createResponse(\Psr\Http\Message\ServerRequestInterface $request): ResponseInterface
    {

        /**
         * @var \Hyperf\HttpServer\Response
         */
       
        $response = ApplicationContext::getContainer()->get(ResponseFactoryInterface::class)->createResponse(401,'unauthorized');
     
        if(str_contains($request->getHeaderLine('Accept'),'application/json')) {
            return $response->withStatus(401,'Unauthorized')->json([
                'code' => 401,
                'message' => 'Unauthorized'
            ]);
        } 
  
        return $response->redirect('/auth/login');
    }
}
