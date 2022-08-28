<?php

declare(strict_types=1);

namespace PeibinLaravel\Server\Handlers;

use Swoole\Server;

class OnStart
{
    public function __construct(public Server $server)
    {
    }
}
