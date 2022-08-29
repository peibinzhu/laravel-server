<?php

declare(strict_types=1);

namespace PeibinLaravel\Server;

use Illuminate\Support\ServiceProvider;
use PeibinLaravel\Process\Events\BeforeProcessHandle;
use PeibinLaravel\Server\Commands\StartServer;
use PeibinLaravel\Server\Listeners\AfterWorkerStartListener;
use PeibinLaravel\Server\Listeners\InitProcessTitleListener;
use PeibinLaravel\SwooleEvent\Events\AfterWorkerStart;
use PeibinLaravel\SwooleEvent\Events\OnManagerStart;
use PeibinLaravel\SwooleEvent\Events\OnStart;
use PeibinLaravel\Utils\Providers\RegisterProviderConfig;
use Swoole\Server as SwooleServer;

class ServerServiceProvider extends ServiceProvider
{
    use RegisterProviderConfig;

    public function __invoke(): array
    {
        $this->app->singleton(ServerFactory::class);

        return [
            'commands'     => [
                StartServer::class,
            ],
            'dependencies' => [
                SwooleServer::class => SwooleServerFactory::class,
            ],
            'listeners'    => [
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
            ],
            'publish'      => [
                [
                    'id'          => 'server',
                    'source'      => __DIR__ . '/../config/server.php',
                    'destination' => config_path('server.php'),
                ],
            ],
        ];
    }
}
