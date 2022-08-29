<?php

declare(strict_types=1);

namespace PeibinLaravel\Server\Events;

use Swoole\Server;

class OnConnect
{
    public function __construct(public Server $server, public int $fd, public int $reactorId)
    {
    }
}
