<?php

declare(strict_types=1);

namespace PeibinLaravel\Server\Bootstraps;

use Illuminate\Contracts\Events\Dispatcher;
use PeibinLaravel\Server\Handlers\AfterWorkerStart;
use PeibinLaravel\Server\Handlers\BeforeWorkerStart;
use PeibinLaravel\Server\Handlers\MainWorkerStart;
use PeibinLaravel\Server\Handlers\OtherWorkerStart;
use PeibinLaravel\Utils\Contracts\StdoutLogger;
use Swoole\Server as SwooleServer;

class WorkerStartCallback
{
    public function __construct(protected Dispatcher $dispatcher, protected StdoutLogger $logger)
    {
    }

    public function onWorkerStart(SwooleServer $server, int $workerId): void
    {
        $this->dispatcher->dispatch(new BeforeWorkerStart($server, $workerId));

        if ($workerId === 0) {
            $this->dispatcher->dispatch(new MainWorkerStart($server, $workerId));
        } else {
            $this->dispatcher->dispatch(new OtherWorkerStart($server, $workerId));
        }

        if ($server->taskworker) {
            $this->logger->info("TaskWorker#{$workerId} started.");
        } else {
            $this->logger->info("Worker#{$workerId} started.");
        }

        $this->dispatcher->dispatch(new AfterWorkerStart($server, $workerId));
    }
}
