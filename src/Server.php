<?php

declare(strict_types=1);

namespace chaser\tcp;

use chaser\stream\ConnectedServer;
use chaser\stream\traits\ServerContext;
use chaser\tcp\subscriber\ServerSubscriber;
use chaser\tcp\traits\Service;

/**
 * tcp 服务器
 *
 * @package chaser\tcp
 *
 * @property Connection[] $connections
 *
 * @property-read int $checkHeartbeatInterval
 */
class Server extends ConnectedServer
{
    use ServerContext, Service;

    /**
     * 默认心跳（收到新的完整请求）检测时间间隔（秒）
     */
    public const CHECK_HEARTBEAT_INTERVAL = 10;

    /**
     * 心跳监测是否进行中
     *
     * @var bool
     */
    protected bool $heartbeatMonitoring = false;

    /**
     * @inheritDoc
     */
    public static function subscriber(): string
    {
        return ServerSubscriber::class;
    }

    /**
     * @inheritDoc
     */
    public static function configurations(): array
    {
        return ['checkHeartbeatInterval' => self::CHECK_HEARTBEAT_INTERVAL] + parent::configurations();
    }

    /**
     * 心跳监测
     */
    public function heartbeatMonitoring(): void
    {
        if (!$this->heartbeatMonitoring) {
            $this->heartbeatMonitoring = true;
            $this->reactor->addInterval($this->checkHeartbeatInterval, function () {
                $now = time();
                foreach ($this->connections as $connection) {
                    $connection->heartbeatCheck($now);
                }
            });
        }
    }

    /**
     * @inheritDoc
     */
    protected function connection($socket): Connection
    {
        return new Connection($this->container, $this, $this->reactor, $socket);
    }

    /**
     * 套接字资源处理
     */
    protected function socketHandle(): void
    {
        parent::socketHandle();
        $this->socketSettings();
    }
}
