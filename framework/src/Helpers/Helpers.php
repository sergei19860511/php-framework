<?php

namespace Sergei\PhpFramework\Helpers;

use Symfony\Component\Dotenv\Dotenv;

final class Helpers
{
    public static function get_env(string $vars): string|bool|null
    {
        $dotenv = new Dotenv();
        $dotenv->load(BASE_PATH.'/.env');

        if (! array_key_exists($vars, $_ENV)) {
            return false;
        }

        return $_ENV[$vars] ?? null;
    }
}
