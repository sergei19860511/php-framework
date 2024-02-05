<?php

namespace Sergei\PhpFramework\Http;

use JetBrains\PhpStorm\NoReturn;
use Sergei\PhpFramework\Http\Response;

class RedirectResponse extends Response
{
    public function __construct(string $url)
    {
        parent::__construct('', 302, ['location' => $url]);
    }

    public function send(): void
    {
        header("Location: {$this->getHeaderKey('location')}", true, $this->getStatusCode());
        exit();
    }
}