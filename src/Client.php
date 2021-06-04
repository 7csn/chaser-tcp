<?php

declare(strict_types=1);

namespace chaser\tcp;

use chaser\stream\ConnectClient;
use chaser\stream\interfaces\part\NetworkAddressInterface;
use chaser\stream\traits\{ClientContext, NetworkAddress};

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
    protected function configureSocket(): void
    {
        parent::configureSocket();
        $this->socketSettings();
    }
}
