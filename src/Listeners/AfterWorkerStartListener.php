<?php

declare(strict_types=1);

namespace PeibinLaravel\Server\Listeners;

use PeibinLaravel\Server\Contracts\ServerInterface;
use PeibinLaravel\Server\Handlers\AfterWorkerStart;
use PeibinLaravel\Server\ServerManager;
use PeibinLaravel\Utils\StdoutLogger;
use Swoole\Coroutine\Server;

class AfterWorkerStartListener
{
    protected StdoutLogger $logger;

    public function __construct()
    {
        $this->logger = new StdoutLogger();
    }

    public function handle(object $event): void
    {
        if (!$event instanceof AfterWorkerStart || $event->workerId !== 0) {
            return;
        }

        foreach (ServerManager::list() as [$type, $server]) {
            $listen = $server->host . ':' . $server->port;
            $type = value(function () use ($type, $server) {
                switch ($type) {
                    case ServerInterface::SERVER_BASE:
                        $sockType = $server->type;
                        // type of Swoole\Coroutine\Server is equal to SWOOLE_SOCK_UDP
                        if (
                            $server instanceof Server ||
                            in_array($sockType, [SWOOLE_SOCK_TCP, SWOOLE_SOCK_TCP6])
                        ) {
                            return 'TCP';
                        }
                        if (in_array($sockType, [SWOOLE_SOCK_UDP, SWOOLE_SOCK_UDP6])) {
                            return 'UDP';
                        }
                        return 'UNKNOWN';
                    case ServerInterface::SERVER_WEBSOCKET:
                        return 'WebSocket';
                    case ServerInterface::SERVER_HTTP:
                    default:
                        return 'HTTP';
                }
            });
            $this->logger->info(sprintf('%s Server listening at %s', $type, $listen));
        }
    }
}
