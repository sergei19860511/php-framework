<?php

require_once dirname(__DIR__).'/vendor/autoload.php';

use Sergei\PhpFramework\Http\Request;
use Sergei\PhpFramework\Http\Response;

$request = Request::createFromGlobals();

$content = 'Hello World!!!';
$response = new Response($content, 200, []);
$response->send();