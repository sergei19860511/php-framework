<?php

namespace Sergei\PhpFramework\Console;

interface CommandInterface
{
    public function execute(array $params = []): int;
}
