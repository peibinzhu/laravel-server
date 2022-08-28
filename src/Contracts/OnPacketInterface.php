<?php

declare(strict_types=1);

namespace PeibinLaravel\Server\Contracts;

use Swoole\Server;

interface OnPacketInterface
{
    public function onPacket(Server $server, string $data, array $clientInfo): void;
}
