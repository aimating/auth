<?php

declare(strict_types=1);

namespace Aimating\Auth\Commands;
use Hyperf\Contract\ConfigInterface;
use Aimating\Oauth2\Commands\GenOauthKeyCommand;
class AuthKeyCommand extends GenOauthKeyCommand
{



    public function __construct(ConfigInterface $config)
    {
        $this->setConfig($config);
        parent::__construct();
        //$this->signature = 'auth:key';
        //$this->description = 'Generate a new auth key';
    }
}
