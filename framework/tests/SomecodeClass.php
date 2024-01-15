<?php

namespace Sergei\PhpFramework\Tests;

class SomecodeClass
{
    public function __construct(private readonly TestDependecys $dependecys)
    {
    }

    public function getDepen(): TestDependecys
    {
        return $this->dependecys;
    }
}
