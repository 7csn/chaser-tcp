<?php

declare(strict_types=1);

namespace chaser\tcp;

use chaser\stream\ConnectedServer;
use chaser\stream\traits\ServerContext;

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
     * @var int
     */
    private int $heartbeatMonitorId;

    /**
     * @inheritDoc
     */
    public static function configurations(): array
    {
        return ['checkHeartbeatInterval' => self::CHECK_HEARTBEAT_INTERVAL] + parent::configurations();
    }

    /**
     * @inheritDoc
     */
    protected function connection($socket): Connection
    {
        return new Connection($this->container, $this, $this->reactor, $socket);
    }

    /**
     * @inheritDoc
     */
    protected function running(): void
    {
        $this->monitorHeartbeat();
        parent::running();
    }

    /**
     * @inheritDoc
     */
    protected function close(): void
    {
        $this->delHeartbeatMonitor();
        parent::close();
    }

    /**
     * @inheritDoc
     */
    protected function configureSocket(): void
    {
        $this->socketSettings();
        parent::configureSocket();
    }

    /**
     * 监测心跳
     */
    private function monitorHeartbeat(): void
    {
        $this->heartbeatMonitorId = $this->reactor->setInterval($this->checkHeartbeatInterval, function () {
            $now = time();
            foreach ($this->connections as $connection) {
                $connection->heartbeatCheck($now);
            }
        });
    }

    /**
     * 移除心跳监测
     */
    private function delHeartbeatMonitor(): void
    {
        if ($this->heartbeatMonitorId > 0) {
            $this->reactor->delInterval($this->heartbeatMonitorId);
        }
    }
}
