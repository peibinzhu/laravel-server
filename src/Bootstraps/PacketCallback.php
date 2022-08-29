<?php

declare(strict_types=1);

namespace PeibinLaravel\Server\Bootstraps;

use Illuminate\Contracts\Events\Dispatcher;
use PeibinLaravel\Server\Events\OnPacket;
use Swoole\Server;

class PacketCallback
{
    public function __construct(protected Dispatcher $dispatcher)
    {
    }

    public function onPacket(Server $server, string $data, array $clientInfo): void
    {
        $this->dispatcher->dispatch(new OnPacket($server, $data, $clientInfo));
    }
}
