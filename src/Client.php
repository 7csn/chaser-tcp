<?php

declare(strict_types=1);

namespace chaser\tcp;

use chaser\stream\ConnectClient;
use chaser\stream\interfaces\part\NetworkAddressInterface;
use chaser\stream\traits\{ClientContext, NetworkAddress};
use chaser\tcp\subscriber\ClientSubscriber;
use chaser\tcp\traits\Service;

/**
 * tcp 客户端类
 *
 * @package chaser\tcp
 */
class Client extends ConnectClient implements NetworkAddressInterface
{
    use ClientContext, NetworkAddress, Service;

    /**
     * @inheritDoc
     */
    public static function subscriber(): string
    {
        return ClientSubscriber::class;
    }

    /**
     * @inheritDoc
     */
    protected function configureSocket(): void
    {
        parent::configureSocket();
        $this->socketSettings();
    }
}
