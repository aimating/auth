<?php

declare(strict_types=1);

namespace Aimating\Auth\Contract;

interface AuthorizationFactoryInterface
{

    public function make():AuthorizationServiceInterface;

}
