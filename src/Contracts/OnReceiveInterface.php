<?php

declare(strict_types=1);

namespace PeibinLaravel\Server\Contracts;

use Swoole\Server;

interface OnReceiveInterface
{
    public function onReceive(Server $server, int $fd, int $reactorId, string $data): void;
}
