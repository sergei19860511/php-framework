<?php

namespace Sergei\PhpFramework\Tests;

class SomecodeClass
{
    public function __construct(private readonly TestDependencies $dependencies)
    {
    }

    public function getDepen(): TestDependencies
    {
        return $this->dependencies;
    }
}
