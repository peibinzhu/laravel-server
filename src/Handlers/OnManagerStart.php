<?php

declare(strict_types=1);

namespace PeibinLaravel\Server\Handlers;

use Swoole\Server;

class OnManagerStart
{
    public function __construct(public Server $server)
    {
    }
}
