<?php

declare(strict_types=1);

namespace chaser\tcp;

use chaser\stream\Connection as StreamConnection;
use chaser\stream\interfaces\part\NetworkAddressInterface;
use chaser\stream\traits\NetworkAddress;
use chaser\tcp\subscriber\ConnectionSubscriber;

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
    protected int $heartbeatTime;

    /**
     * @inheritDoc
     */
    public static function subscriber(): string
    {
        return ConnectionSubscriber::class;
    }

    /**
     * @inheritDoc
     */
    public static function configurations(): array
    {
        return ['heartbeatTimeout' => self::HEARTBEAT_TIMEOUT] + parent::configurations();
    }

    /**
     * 心跳（记录时间）
     *
     * @param int|null $time
     */
    public function heartbeat(int $time = null): void
    {
        $this->heartbeatTime = $time ?? time();
    }

    /**
     * 心跳（收到新的完整请求）超时检测
     *
     * @param int|null $time
     */
    public function heartbeatCheck(int $time = null): void
    {
        if ($time === null) {
            $time = time();
        }
        if (empty($this->heartbeatTime)) {
            $this->heartbeat($time);
        } elseif ($this->heartbeatTime + $this->heartbeatTimeout < $time) {
            $this->close();
        }
    }
}
