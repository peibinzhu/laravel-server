<?php

declare(strict_types=1);

namespace PeibinLaravel\Server\Bootstraps;

use Illuminate\Contracts\Events\Dispatcher;
use PeibinLaravel\Server\Events\OnFinish;
use Swoole\Server;

class FinishCallback
{
    public function __construct(protected Dispatcher $dispatcher)
    {
    }

    public function onFinish(Server $server, int $taskId, $data): void
    {
        $this->dispatcher->dispatch(new OnFinish($server, $taskId, $data));
    }
}
