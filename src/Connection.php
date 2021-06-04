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
 *
 * @property-read int $heartbeatTimeout
 */
class Connection extends StreamConnection implements NetworkAddressInterface
{
    use NetworkAddress;

    /**
     * 默认心跳（收到新的完整请求）时间间隔上限（秒）
     */
    public const HEARTBEAT_TIMEOUT = 55;

    /**
     * 心跳（收到新的完整请求）时间
     *
     * @var int
     */
    protected int $heartbeatTime = 0;

    /**
     * @inheritDoc
     */
    public static function configurations(): array
    {
        return ['heartbeatTimeout' => self::HEARTBEAT_TIMEOUT] + parent::configurations();
    }

    /**
     * 心跳（收到新的完整请求）超时检测
     *
     * @param int $time
     */
    public function heartbeatCheck(int $time): void
    {
        if ($this->heartbeatTime + $this->heartbeatTimeout < $time) {
            $this->close();
        }
    }

    /**
     * @inheritDoc
     */
    protected function dispatchEstablish(): void
    {
        $this->heartbeatTime = time();
        parent::dispatchEstablish();
    }

    /**
     * @inheritDoc
     */
    protected function dispatchMessage(mixed $message): void
    {
        $this->heartbeatTime = time();
        parent::dispatchMessage($message);
    }
}
