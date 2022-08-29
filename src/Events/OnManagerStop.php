<?php

declare(strict_types=1);

namespace PeibinLaravel\Server\Events;

use Swoole\Server;

class OnManagerStop
{
    public function __construct(public Server $server)
    {
    }
}
