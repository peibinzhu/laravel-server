<?php

declare(strict_types=1);

namespace PeibinLaravel\Server\Bootstraps;

use Illuminate\Contracts\Events\Dispatcher;
use PeibinLaravel\Server\Events\OnPipeMessage;
use Swoole\Server as SwooleServer;

class PipeMessageCallback
{
    public function __construct(protected Dispatcher $dispatcher)
    {
    }

    public function onPipeMessage(SwooleServer $server, int $fromWorkerId, $data): void
    {
        $this->dispatcher->dispatch(new OnPipeMessage($server, $fromWorkerId, $data));
    }
}
