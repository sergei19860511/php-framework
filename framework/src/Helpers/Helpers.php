<?php

namespace Sergei\PhpFramework\Helpers;

use Symfony\Component\Dotenv\Dotenv;

final class Helpers
{
    public static function get_env(string $id): string|bool
    {
        $dotenv = new Dotenv();
        $dotenv->load(BASE_PATH.'/.env');
        if (! in_array($id, $_ENV)) {
            return false;
        }

        return $_ENV[$id];
    }
}
