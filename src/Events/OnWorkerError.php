<?php

declare(strict_types=1);

namespace PeibinLaravel\Server\Events;

use Swoole\Server;

class OnWorkerError
{
    public function __construct(
        public Server $server,
        public int $workerId,
        public int $workerPid,
        public int $exitCode,
        public int $signal
    ) {
    }
}
