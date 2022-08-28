<?php

declare(strict_types=1);

namespace PeibinLaravel\Server;

use Illuminate\Contracts\Events\Dispatcher;
use PeibinLaravel\Server\Contracts\ServerInterface;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class ServerFactory
{
    protected ?LoggerInterface $logger = null;

    protected ?Dispatcher $eventDispatcher = null;

    protected ?ServerInterface $server = null;

    protected ?ServerConfig $config = null;

    public function __construct(protected ContainerInterface $container)
    {
    }

    public function configure(array $config): void
    {
        $this->config = new ServerConfig($config);

        $this->getServer()->init($this->config);
    }

    public function start(): void
    {
        $this->getServer()->start();
    }

    public function getServer(): ServerInterface
    {
        if (!$this->server instanceof ServerInterface) {
            $serverName = $this->config->getType();
            $this->server = new $serverName(
                $this->container,
                $this->getLogger(),
                $this->getEventDispatcher()
            );
        }

        return $this->server;
    }

    public function setServer(ServerInterface $server): static
    {
        $this->server = $server;
        return $this;
    }

    public function getEventDispatcher(): Dispatcher
    {
        if ($this->eventDispatcher instanceof Dispatcher) {
            return $this->eventDispatcher;
        }
        return $this->getDefaultEventDispatcher();
    }

    public function setEventDispatcher(Dispatcher $eventDispatcher): static
    {
        $this->eventDispatcher = $eventDispatcher;
        return $this;
    }

    public function getLogger(): LoggerInterface
    {
        if ($this->logger instanceof LoggerInterface) {
            return $this->logger;
        }
        return $this->getDefaultLogger();
    }

    public function setLogger(LoggerInterface $logger): static
    {
        $this->logger = $logger;
        return $this;
    }

    private function getDefaultEventDispatcher(): Dispatcher
    {
        return $this->container->get(Dispatcher::class);
    }

    private function getDefaultLogger(): LoggerInterface
    {
        return $this->container->get(LoggerInterface::class);
    }
}
