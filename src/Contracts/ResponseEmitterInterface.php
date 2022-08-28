<?php

declare(strict_types=1);

namespace PeibinLaravel\Server\Contracts;

use Symfony\Component\HttpFoundation\Response;

interface ResponseEmitterInterface
{
    /**
     * @param Response $response
     * @param mixed    $connection swoole response or swow session.
     * @param bool     $withContent
     */
    public function emit(Response $response, mixed $connection, bool $withContent = true): void;
}
