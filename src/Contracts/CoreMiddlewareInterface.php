<?php

declare(strict_types=1);

namespace PeibinLaravel\Server\Contracts;

use PeibinLaravel\Contracts\MiddlewareInterface;
use Symfony\Component\HttpFoundation\Request;

interface CoreMiddlewareInterface extends MiddlewareInterface
{
    public function dispatch(Request $request): Request;
}
