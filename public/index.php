<?php

require_once dirname(__DIR__).'/vendor/autoload.php';

use Sergei\PhpFramework\Http\Kernel;
use Sergei\PhpFramework\Http\Request;

$request = Request::createFromGlobals();
$kernel = new Kernel();
$response = $kernel->handle($request);
$response->send();