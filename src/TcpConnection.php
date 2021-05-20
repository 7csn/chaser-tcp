<?php

declare(strict_types=1);

namespace chaser\tcp;

use chaser\stream\Connection as StreamConnection;
use chaser\stream\traits\NetworkAddress;

/**
 * tcp 连接
 *
 * @package chaser\tcp
 *
 * @property int $heartbeatTimeout
 */
class TcpConnection extends StreamConnection implements TcpConnectionInterface
{
    use NetworkAddress;

    /**
     * 常规配置
     *
     * @var array
     */
    protected array $configurations = [
        'readBufferSize' => self::READ_BUFFER_SIZE,
        'maxRecvBufferSize' => self::MAX_REQUEST_BUFFER_SIZE,
        'maxSendBufferSize' => self::MAX_RESPONSE_BUFFER_SIZE,
        'heartbeatTimeout' => self::HEARTBEAT_TIMEOUT
    ];

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
        return TcpConnectionSubscriber::class;
    }

    /**
     * 设置心跳（收到新的完整请求）时间
     *
     * @param int|null $time
     */
    public function setHeartbeatTime(?int $time = null): void
    {
        $this->heartbeatTime = $time ?? time();
    }

    /**
     * 心跳（收到新的完整请求）超时检测
     *
     * @param int|null $time
     */
    public function heartbeatCheck(?int $time = null): void
    {
        if ($time === null) {
            $time = time();
        }
        if (!$this->heartbeatTime) {
            $this->setHeartbeatTime($time);
        } elseif ($this->heartbeatTime + $this->heartbeatTimeout < $time) {
            $this->close();
        }
    }
}
