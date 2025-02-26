<?php

declare(strict_types=1);

namespace Aimating\Auth\Model;
use Hyperf\Context\ApplicationContext;
use Hyperf\Snowflake\IdGeneratorInterface;
trait Snowflake
{

    public function createKey()
    {
        if (! $this->getKey()) {
            $container = ApplicationContext::getContainer();
            $generator = $container->get(IdGeneratorInterface::class);
            $this->{$this->getKeyName()} = $generator->generate();
        }
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'int';
    }
}
