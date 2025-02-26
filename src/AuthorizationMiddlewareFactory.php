<?php

declare(strict_types=1);

namespace Aimating\Auth;
use League\OAuth2\Server\AuthorizationServer;
use Psr\Container\ContainerInterface;
use Aimating\Oauth2\AuthorizationMiddleware;
class AuthorizationMiddlewareFactory
{

    public function __invoke(ContainerInterface $container): AuthorizationMiddleware
    {
        return new AuthorizationMiddleware(
            $container->get(AuthorizationServer::class),
             $container->get(\Psr\Http\Message\ResponseFactoryInterface::class)
         );
    }

}
