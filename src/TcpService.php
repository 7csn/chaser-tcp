<?php

declare(strict_types=1);

namespace chaser\tcp;

/**
 * tcp 服务特征
 *
 * @package chaser\tcp
 */
trait TcpService
{
    /**
     * @inheritDoc
     */
    public static function transport(): string
    {
        return 'tcp';
    }
}
