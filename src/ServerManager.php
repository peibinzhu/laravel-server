<?php

declare(strict_types=1);

namespace PeibinLaravel\Server;

use PeibinLaravel\Utils\Traits\Container;

class ServerManager
{
    use Container;

    /**
     * @param array $value [$serverType, $server]
     */
    public static function add(string $name, array $value): void
    {
        self::set($name, $value);
    }
}
