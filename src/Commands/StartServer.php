<?php

declare(strict_types=1);

namespace PeibinLaravel\Server\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use InvalidArgumentException;
use PeibinLaravel\Contracts\StdoutLoggerInterface;
use PeibinLaravel\Engine\Coroutine;
use PeibinLaravel\Server\ServerFactory;

class StartServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'server:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start laravel servers.';

    /**
     * Create a new console command instance.
     *
     * @return void
     */
    public function __construct(protected Container $container)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $serverFactory = $this->container->get(ServerFactory::class)
            ->setEventDispatcher($this->container->get(Dispatcher::class))
            ->setLogger($this->container->get(StdoutLoggerInterface::class));

        $serverConfig = $this->container->get(Repository::class)->get('server', []);
        if (!$serverConfig) {
            throw new InvalidArgumentException('At least one server should be defined.');
        }

        $serverFactory->configure($serverConfig);

        Coroutine::set(['hook_flags' => SWOOLE_HOOK_ALL]);

        $serverFactory->start();
    }
}
