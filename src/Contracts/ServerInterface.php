<?php

declare(strict_types=1);

namespace PeibinLaravel\Server\Contracts;

use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use PeibinLaravel\Server\ServerConfig;
use Psr\Log\LoggerInterface;
use Swoole\Coroutine\Server as SwooleCoServer;
use Swoole\Server as SwooleServer;

interface ServerInterface
{
    public const SERVER_HTTP = 1;

    public const SERVER_WEBSOCKET = 2;

    public const SERVER_BASE = 3;

    public function __construct(
        Container $container,
        LoggerInterface $logger,
        Dispatcher $dispatcher
    );

    public function init(ServerConfig $config): static;

    public function start(): void;

    /**
     * @return SwooleCoServer|SwooleServer
     */
    public function getServer(): SwooleServer | SwooleCoServer;
}
