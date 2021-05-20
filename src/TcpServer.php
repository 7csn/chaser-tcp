<?php

namespace chaser\tcp;

use chaser\stream\ConnectedServer;
use chaser\stream\traits\ServerContext;

/**
 * tcp 服务器
 *
 * @package chaser\tcp
 *
 * @property int $checkHeartbeatInterval
 * @property array<TcpConnection> $connections
 */
class TcpServer extends ConnectedServer implements TcpServerInterface
{
    use ServerContext, TcpService;

    /**
     * 常规配置
     *
     * @var array
     */
    protected array $configurations = [
        'connection' => [],
        'connectionSubscriber' => '',
        'checkHeartbeatInterval' => self::CHECK_HEARTBEAT_INTERVAL
    ];

    /**
     * 心跳检测是否进行中
     *
     * @var bool
     */
    protected bool $heartbeatChecking = false;

    /**
     * @inheritDoc
     */
    public static function subscriber(): string
    {
        return TcpServerSubscriber::class;
    }

    /**
     * @inheritDoc
     */
    public function connection($stream): TcpConnection
    {
        return new TcpConnection($this, $this->reactor, $stream);
    }

    /**
     * 心跳检测
     */
    public function heartbeatCheck(): void
    {
        if (!$this->heartbeatChecking) {
            $this->heartbeatChecking = true;
            $this->reactor->addInterval($this->checkHeartbeatInterval, function () {
                $now = time();
                foreach ($this->connections as $connection) {
                    $connection->heartbeatCheck($now);
                }
            });
        }
    }
}
