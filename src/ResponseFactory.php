<?php

declare(strict_types=1);

namespace Aimating\Auth;
use Hyperf\HttpServer\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
class ResponseFactory implements ResponseFactoryInterface
{

    public function __construct(private ContainerInterface $container)
    {
    }
    
     public function createResponse($code = 200,string $reasonPhrase = ''): Response
    {
        return new Response();
    }
}
