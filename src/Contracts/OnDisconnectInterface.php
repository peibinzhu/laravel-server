<?php

declare(strict_types=1);

namespace PeibinLaravel\Server\Contracts;

use Swoole\WebSocket\Server;

interface OnDisconnectInterface
{
    public function onDisconnect(Server $server, $fd): void;
}
