<?php

declare(strict_types=1);

namespace PeibinLaravel\Server\Bootstraps;

use Illuminate\Contracts\Events\Dispatcher;
use PeibinLaravel\Server\Events\OnManagerStop;
use Swoole\Server as SwooleServer;

class ManagerStopCallback
{
    public function __construct(protected Dispatcher $dispatcher)
    {
    }

    public function onManagerStop(SwooleServer $server): void
    {
        $this->dispatcher->dispatch(new OnManagerStop($server));
    }
}
