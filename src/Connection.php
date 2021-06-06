<?php

declare(strict_types=1);

namespace chaser\tcp;

use chaser\stream\Connection as StreamConnection;
use chaser\stream\interfaces\part\NetworkAddressInterface;
use chaser\stream\traits\NetworkAddress;

/**
 * tcp 连接
 *
 * @package chaser\tcp
 *
 * @property-read Server $server
 * @property-read int $heartbeatTime
 */
class Connection extends StreamConnection implements NetworkAddressInterface
{
    use NetworkAddress;

    /**
     * 心跳时间
     *
     * @var int
     */
    protected int $heartbeatTime = 0;

    /**
     * @inheritDoc
     */
    protected function initCommon(): void
    {
        $this->heartbeat();
        parent::initCommon();
    }

    /**
     * @inheritDoc
     */
    protected function dispatchMessage(mixed $message): void
    {
        $this->heartbeat();
        parent::dispatchMessage($message);
    }

    /**
     * 心跳
     */
    private function heartbeat(): void
    {
        $this->heartbeatTime = time();
    }
}
