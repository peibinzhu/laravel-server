<?php

declare(strict_types=1);

namespace PeibinLaravel\Server\Contracts;

use Swoole\Server;

interface OnCloseInterface
{
    public function onClose(Server $server, int $fd, int $reactorId): void;
}
