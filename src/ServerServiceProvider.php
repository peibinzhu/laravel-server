<?php

declare(strict_types=1);

namespace PeibinLaravel\Server;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use PeibinLaravel\Process\Events\BeforeProcessHandle;
use PeibinLaravel\Server\Commands\StartServer;
use PeibinLaravel\Server\Listeners\AfterWorkerStartListener;
use PeibinLaravel\Server\Listeners\InitProcessTitleListener;
use PeibinLaravel\SwooleEvent\Events\AfterWorkerStart;
use PeibinLaravel\SwooleEvent\Events\OnManagerStart;
use PeibinLaravel\SwooleEvent\Events\OnStart;
use Swoole\Server as SwooleServer;

class ServerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $dependencies = [
            SwooleServer::class  => SwooleServerFactory::class,
            ServerFactory::class => ServerFactory::class,
        ];
        $this->registerDependencies($dependencies);

        $listeners = [
            OnStart::class             => [
                InitProcessTitleListener::class,
            ],
            OnManagerStart::class      => [
                InitProcessTitleListener::class,
            ],
            AfterWorkerStart::class    => [
                AfterWorkerStartListener::class,
                InitProcessTitleListener::class,
            ],
            BeforeProcessHandle::class => [
                InitProcessTitleListener::class,
            ],
        ];
        $this->registerListeners($listeners);

        $this->registerPublishing();

        $this->commands(StartServer::class);
    }

    private function registerDependencies(array $dependencies)
    {
        foreach ($dependencies as $abstract => $concrete) {
            if (is_string($concrete) && method_exists($concrete, '__invoke')) {
                $concrete = function () use ($concrete) {
                    return $this->app->call($concrete . '@__invoke');
                };
            }
            $this->app->singleton($abstract, $concrete);
        }
    }

    private function registerListeners(array $listeners)
    {
        $dispatcher = $this->app->get(Dispatcher::class);
        foreach ($listeners as $event => $_listeners) {
            foreach ((array)$_listeners as $listener) {
                $dispatcher->listen($event, $listener);
            }
        }
    }

    public function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/server.php' => config_path('server.php'),
            ], 'server');
        }
    }
}
