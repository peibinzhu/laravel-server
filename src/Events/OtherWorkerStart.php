<?php

declare(strict_types=1);

namespace PeibinLaravel\Server\Events;

use Swoole\Server;

class OtherWorkerStart
{
    public function __construct(public Server $server, public int $workerId)
    {
    }
}