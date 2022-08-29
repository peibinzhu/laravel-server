<?php

declare(strict_types=1);

namespace PeibinLaravel\Server;

use Illuminate\Support\ServiceProvider;
use PeibinLaravel\Process\Events\BeforeProcessHandle;
use PeibinLaravel\Server\Commands\StartServer;
use PeibinLaravel\Server\Events\AfterWorkerStart;
use PeibinLaravel\Server\Events\OnManagerStart;
use PeibinLaravel\Server\Events\OnStart;
use PeibinLaravel\Server\Listeners\AfterWorkerStartListener;
use PeibinLaravel\Server\Listeners\InitProcessTitleListener;
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
