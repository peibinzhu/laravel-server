<?php

declare(strict_types=1);

namespace PeibinLaravel\Server\Contracts;

use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;

interface OnMessageInterface
{
    public function onMessage(Server $server, Frame $frame): void;
}
