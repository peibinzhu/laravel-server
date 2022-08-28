<?php

declare(strict_types=1);

namespace PeibinLaravel\Server\Handlers;

class BeforeServerStart
{
    public function __construct(public string $serverName)
    {
    }
}
