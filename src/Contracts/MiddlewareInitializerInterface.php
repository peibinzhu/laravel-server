<?php

declare(strict_types=1);

namespace PeibinLaravel\Server\Contracts;

interface MiddlewareInitializerInterface
{
    public function initCoreMiddleware(string $serverName): void;
}
