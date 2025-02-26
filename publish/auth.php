<?php
declare(strict_types=1);

return [
    'default' => [
        'guard' => 'web',
        'provider' => 'users'
    ],
    'guards' => [
        'web' => [
            'driver' => \Aimating\Auth\Grands\OauthTokenGrand::class,
            'provider' => 'users',
        ]
    ],
    'providers' => [
        'users' => [
            'driver' => \Aimating\Oauth2\TokenAuthorizationServiceHandler::class,
             'options'=> [
                'user_model' => \App\Model\User::class,
             ]
        ]
    ]
];