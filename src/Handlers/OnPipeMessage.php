<?php

declare(strict_types=1);

namespace PeibinLaravel\Server\Handlers;

use Swoole\Server;

class OnPipeMessage
{
    public function __construct(public Server $server, public int $fromWorkerId, public mixed $data)
    {
    }
}
