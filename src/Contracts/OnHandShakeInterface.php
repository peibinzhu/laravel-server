<?php

declare(strict_types=1);

namespace PeibinLaravel\Server\Contracts;

use Swoole\Http\Request;
use Swoole\Http\Response;

interface OnHandShakeInterface
{
    public function onHandShake(Request $request, Response $response): void;
}
