<?php

declare(strict_types=1);

namespace PeibinLaravel\Server\Contracts;

use Swoole\Http\Request;
use Swoole\WebSocket\Server;

interface OnOpenInterface
{
    public function onOpen(Server $server, Request $request): void;
}
