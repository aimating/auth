<?php

declare(strict_types=1);

namespace Aimating\Auth;
use Aimating\Auth\Contract\AuthManagerInterface;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Contract\ContainerInterface;
use Aimating\Auth\Contract\GuardInterface;
use Aimating\Oauth2\Contract\AuthenticationInterface;
use InvalidArgumentException;
class AuthManager implements AuthManagerInterface
{

    use ContextHelpers;
    protected $defaultGuard = 'web';
    protected $guardName = null;


    protected $providers = [];

    protected $container;

    protected $config;

    const SERVICE_KEY ='server_key';
    
     const RESOURCE_SERVER_KEY =  'source_key';

     

     private $resourceServer = null;
    public function __construct(ContainerInterface $container)
    {
        $this->config = $container->get(ConfigInterface::class);
        $this->container = $container;
    }

    public function guard($name = null): GuardInterface
    {
       $this->guardName = $name = $name ?: $this->getDefaultGuard();
        $id = 'guards.' . $name;
        return $this->getContext($id) ?: $this->setContext($id, $this->resolve($name));
        
        
    }


    protected function resolve($name)
    {
        $config = $this->getConfig($name);

        if (empty($config)) {
            throw new InvalidArgumentException("Auth guard [{$name}] is not defined.");
        }

        if (empty($config['driver'])) {
            throw new InvalidArgumentException("Auth guard [{$name}] is not defined.");
        }
       
        $provider = $this->resolveProvider($config['provider'] ?? null);

      // if($provider) $this->setContext('auth:guard:'.$name, $provider->getAuthorizationServer());


        return $this->container->make($config['driver'],[
            'container' => $this->container,
            'authServer' => $provider,
            'sourceServer' => $this->makeResourceService(),
        ]);

   
    }
    
    public function getConfig(string $name):array {
        return $this->config->get("auth.guards.{$name}");
    }

    public function makeResourceService() {

 
        if($this->resourceServer === null ) {
           
            $this->resourceServer = $this->container->get(AuthenticationInterface::class);
        }
              
        return $this->resourceServer;
    }

   
    protected function resolveProvider(?string $provider = null)
    {
        $provider = $provider ?: $this->config->get('auth.default.provider', null);

        $config = $this->config->get('auth.providers.' . $provider);

        if (is_null($config)) {
            throw new InvalidArgumentException(
                "Authentication user provider [{$provider}] must be defined."
            );
        }

        $driverClass = $config['driver'] ?? null;
        if (empty($driverClass)) {
            throw new InvalidArgumentException(
                'Authentication user provider driver must be defined.'
            );
        }

        $options = $config['options'] ?? [];
        if(empty($options['user_model'])) throw new InvalidArgumentException("Auth guard [user_model] is not defined.");
        $this->container->define(\Aimating\Oauth2\Contract\UserProviderInterface::class,$options['user_model']);

        return $this->container->get($driverClass);
    }


   

    public function setName(string $name): AuthManagerInterface
    {
        return $this;
    }


    public function mergeConfig(array $config): AuthManagerInterface
    {
        
        return $this;
    }

    public function setDefaultProvider(string $name): AuthManagerInterface
    {
        $this->config->set('auth.default.provider',$name);
        return $this;
    }

    public function getDefaultProvider()
    {
        return $this->config->get('auth.default.provider', 'users');
    }
    public function setDefaultGuard(string $name): AuthManagerInterface
    {
        $this->defaultGuard = $name;
        return $this;
    }

    public function getDefaultGuard(): string
    {
        return $this->defaultGuard;
    }
}
