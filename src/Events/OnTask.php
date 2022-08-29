<?php

declare(strict_types=1);

namespace PeibinLaravel\Server\Events;

use Psr\EventDispatcher\StoppableEventInterface;
use Swoole\Server;
use Swoole\Server\Task;

class OnTask implements StoppableEventInterface
{
    public mixed $result = null;

    public function __construct(public Server $server, public Task $task)
    {
    }

    public function setResult(mixed $result): static
    {
        $this->result = $result;
        return $this;
    }

    public function isPropagationStopped(): bool
    {
        return !is_null($this->result);
    }
}
