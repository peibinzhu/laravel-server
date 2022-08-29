<?php

declare(strict_types=1);

namespace PeibinLaravel\Server\Bootstraps;

use Illuminate\Contracts\Events\Dispatcher;
use PeibinLaravel\Server\Events\OnClose;
use Swoole\Server;

class CloseCallback
{
    public function __construct(protected Dispatcher $dispatcher)
    {
    }

    public function onClose(Server $server, int $fd, int $reactorId): void
    {
        $this->dispatcher->dispatch(new OnClose($server, $fd, $reactorId));
    }
}
