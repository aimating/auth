<?php

declare(strict_types=1);

namespace Aimating\Auth;
use Aimating\Auth\Contract\AuthManagerInterface;
use Aimating\Auth\Contract\AuthorizationServiceInterface;
use Aimating\Oauth2\Contract\ConfigInterface;
use Hyperf\Contract\ConfigInterface as ConfigFacty;
use Aimating\Oauth2\Contract\ModelAccessTokenInteface;
use Aimating\Oauth2\Contract\ModelAuthCodeInterface;
use Aimating\Oauth2\Contract\ModelClientInterface;
use Aimating\Oauth2\Contract\ModelRefreshTokenInterface;
use Aimating\Oauth2\Contract\ModelSocpeInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Aimating\Oauth2\AuthorizationMiddleware;
class ConfigProvider
{

    public function __invoke(): array
    {
        return [
            'dependencies' => [
                ModelAccessTokenInteface::class => \Aimating\Auth\Model\OauthAccessToken::class,
                ModelAuthCodeInterface::class => \Aimating\Auth\Model\OauthAuthCode::class,
                ModelClientInterface::class => \Aimating\Auth\Model\OauthClient::class,
                ModelRefreshTokenInterface::class => \Aimating\Auth\Model\OauthRefreshToken::class,
                AuthManagerInterface::class => AuthManager::class,
                ConfigInterface::class  => static fn($container) => $container->get(ConfigFacty::class),
                ResponseFactoryInterface::class => \Aimating\Auth\ResponseFactory::class,
                AuthorizationMiddleware::class   => AuthorizationMiddlewareFactory::class,
            ],
            'listeners' => [
            
            ],
            'commands' => [
                Commands\AuthKeyCommand::class,
            ],
            'publish' => [
                [
                    'id' => 'config',
                    'description' => 'The config for Auth.',
                    'source' => __DIR__ . '/../publish/auth.php',
                    'destination' => BASE_PATH . '/config/autoload/auth.php',
                ],
                [
                    'id' => 'migration',
                    'description' => 'The migration for Oauth2.',
                    'source' => __DIR__ . '/../migrations',
                    'destination' => BASE_PATH . '/migrations',
                ],
            ],
            'annotations' => [
                'scan' => [
                    'paths' => [
                        __DIR__,
                    ],
                ],
            ],
        ];
    } 
}
