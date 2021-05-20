<?php

declare(strict_types=1);

namespace chaser\tcp;

use chaser\stream\ConnectedClient;
use chaser\stream\interfaces\parts\NetworkAddressInterface;
use chaser\stream\traits\ClientContext;
use chaser\stream\traits\NetworkAddress;

/**
 * tcp 客户端类
 *
 * @package chaser\tcp
 */
class TcpClient extends ConnectedClient implements NetworkAddressInterface
{
    use ClientContext, NetworkAddress, TcpService;

    /**
     * @inheritDoc
     */
    public static function subscriber(): string
    {
        return TcpClientSubscriber::class;
    }
}
