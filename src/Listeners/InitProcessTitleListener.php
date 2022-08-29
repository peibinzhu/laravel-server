<?php

declare(strict_types=1);

namespace PeibinLaravel\Server\Listeners;

use Illuminate\Contracts\Config\Repository;
use PeibinLaravel\Process\Events\BeforeProcessHandle;
use PeibinLaravel\Server\Events\AfterWorkerStart;
use PeibinLaravel\Server\Events\OnManagerStart;
use PeibinLaravel\Server\Events\OnStart;

class InitProcessTitleListener
{
    protected string $name = '';

    protected string $dot = '.';

    public function __construct(Repository $config)
    {
        if ($name = $config->get('app.name')) {
            $this->name = $name;
        }
    }

    public function handle(object $event): void
    {
        $array = [];
        if ($this->name !== '') {
            $array[] = $this->name;
        }

        if ($event instanceof OnStart) {
            $array[] = 'Master';
        } elseif ($event instanceof OnManagerStart) {
            $array[] = 'Manager';
        } elseif ($event instanceof AfterWorkerStart) {
            if ($event->server->taskworker) {
                $array[] = 'TaskWorker';
            } else {
                $array[] = 'Worker';
            }
            $array[] = $event->workerId;
        } elseif ($event instanceof BeforeProcessHandle) {
            $array[] = $event->process->name;
            $array[] = $event->index;
        }

        if ($title = implode($this->dot, $array)) {
            $this->setTitle($title);
        }
    }

    protected function setTitle(string $title): void
    {
        if ($this->isSupportedOS()) {
            @cli_set_process_title($title);
        }
    }

    protected function isSupportedOS(): bool
    {
        return PHP_OS != 'Darwin';
    }
}
