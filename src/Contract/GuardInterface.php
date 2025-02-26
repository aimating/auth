<?php

declare(strict_types=1);

namespace Aimating\Auth\Contract;
use Hyperf\HttpMessage\Base\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use League\OAuth2\Server\AuthorizationServer;
use Aimating\Oauth2\Contract\AuthenticatableInterface;
interface GuardInterface
{

    public function issueToken(ServerRequestInterface $request,ResponseInterface $response):ResponseInterface;

    public function getUser():?AuthenticatableInterface;


    public function setUser(AuthenticatableInterface $user):self;

    public function check():bool;

    public function logout():void;

    public function login($username, $password):?AuthenticatableInterface;

    public function authenticate(ServerRequestInterface $request):ServerRequestInterface;

    public function authorize(ServerRequestInterface $request,ResponseInterface $response):ResponseInterface;


}
