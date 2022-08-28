<?php

declare(strict_types=1);

namespace PeibinLaravel\Server\Handlers;

use Swoole\Server;

class OnClose
{
    public function __construct(public Server $server, public int $fd, public int $reactorId)
    {
    }
}