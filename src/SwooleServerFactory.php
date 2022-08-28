<?php

declare(strict_types=1);

namespace PeibinLaravel\Server;

use Illuminate\Contracts\Container\Container;
use Swoole\Server;

class SwooleServerFactory
{
    public function __invoke(Container $container): Server
    {
        $factory = $container->get(ServerFactory::class);
        return $factory->getServer()->getServer();
    }
}
