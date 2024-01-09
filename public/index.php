<?php

require_once dirname(__DIR__).'/vendor/autoload.php';

use Sergei\PhpFramework\Http\Request;

dd(Request::createFromGlobals());