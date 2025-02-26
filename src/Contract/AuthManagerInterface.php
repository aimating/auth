<?php

declare(strict_types=1);

namespace Aimating\Auth\Contract;

interface AuthManagerInterface
{

    public function guard($name = null): GuardInterface;

    public function getDefaultGuard(): string;

    public function setDefaultGuard(string $name): self;

    public function setName(string $name): self;


}
