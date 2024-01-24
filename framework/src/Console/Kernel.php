<?php

namespace Sergei\PhpFramework\Console;

use Doctrine\DBAL\Connection;
use League\Container\Container;
use Sergei\PhpFramework\Http\Exceptions\HttpException;
use Sergei\PhpFramework\Http\Request;
use Sergei\PhpFramework\Http\Response;
use Sergei\PhpFramework\Routing\RouterInterface;

class Kernel
{
    public function handle(): int
    {
        dd('console');
        return 0;
    }
}
