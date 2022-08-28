<?php

declare(strict_types=1);

namespace PeibinLaravel\Server\Bootstraps;

use Illuminate\Contracts\Events\Dispatcher;
use PeibinLaravel\Server\Handlers\OnConnect;
use Swoole\Server;

class ConnectCallback
{
    public function __construct(protected Dispatcher $dispatcher)
    {
    }

    public function onConnect(Server $server, int $fd, int $reactorId): void
    {
        $this->dispatcher->dispatch(new OnConnect($server, $fd, $reactorId));
    }
}
