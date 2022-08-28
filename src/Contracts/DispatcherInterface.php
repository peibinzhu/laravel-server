<?php

declare(strict_types=1);

namespace PeibinLaravel\Server\Contracts;

interface DispatcherInterface
{
    public function dispatch(...$params): mixed;
}
