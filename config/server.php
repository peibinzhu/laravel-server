<?php

declare(strict_types=1);

use PeibinLaravel\Server\Contracts\ServerInterface;
use PeibinLaravel\Server\Event;

return [
    'mode'      => SWOOLE_BASE,
    'servers'   => [
        [
            'name'      => 'ws',
            'type'      => ServerInterface::SERVER_WEBSOCKET,
            'host'      => '127.0.0.1',
            'port'      => 8000,
            'sock_type' => SWOOLE_SOCK_TCP,
            'callbacks' => [
                Event::ON_HAND_SHAKE => [PeibinLaravel\WebSocketServer\Server::class, 'onHandShake'],
                Event::ON_MESSAGE    => [PeibinLaravel\WebSocketServer\Server::class, 'onMessage'],
                Event::ON_CLOSE      => [PeibinLaravel\WebSocketServer\Server::class, 'onClose'],
            ],
        ],
    ],
    'settings'  => [
        'enable_coroutine'    => true,
        'worker_num'          => 4,
        'pid_file'            => base_path('runtime/laravel.pid'),
        'open_tcp_nodelay'    => true,
        'max_coroutine'       => 100000,
        'open_http2_protocol' => true,
        'max_request'         => 0,
        'socket_buffer_size'  => 2 * 1024 * 1024,
    ],
    'callbacks' => [
        Event::ON_BEFORE_START => [PeibinLaravel\SwooleEvent\Bootstraps\ServerStartCallback::class, 'beforeStart'],
        Event::ON_WORKER_START => [PeibinLaravel\SwooleEvent\Bootstraps\WorkerStartCallback::class, 'onWorkerStart'],
        Event::ON_PIPE_MESSAGE => [PeibinLaravel\SwooleEvent\Bootstraps\PipeMessageCallback::class, 'onPipeMessage'],
        Event::ON_WORKER_EXIT  => [PeibinLaravel\SwooleEvent\Bootstraps\WorkerExitCallback::class, 'onWorkerExit'],
    ],
];
