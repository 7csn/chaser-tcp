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
 * @property-read int $heartbeatTimeout
 * @property-read int $checkHeartbeatInterval
 */
class Server extends ConnectedServer
{
    use ServerContext, Service;

    /**
     * 默认心跳（收到新的完整请求）时间间隔上限（秒）
     */
    public const HEARTBEAT_TIMEOUT = 55;

    /**
     * 默认心跳（收到新的完整请求）检测时间间隔（秒）
     */
    public const CHECK_HEARTBEAT_INTERVAL = 10;

    /**
     * 心电图 ID
     *
     * @var int
     */
    private int $ekgId = 0;

    /**
     * @inheritDoc
     */
    public static function configurations(): array
    {
        return [
                'heartbeatTimeout' => self::HEARTBEAT_TIMEOUT,
                'checkHeartbeatInterval' => self::CHECK_HEARTBEAT_INTERVAL
            ]
            + parent::configurations();
    }

    /**
     * @inheritDoc
     */
    protected function initCommon(): void
    {
        parent::initCommon();

        $this->reusePort();
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
        $this->onEkg();
        parent::running();
    }

    /**
     * @inheritDoc
     */
    protected function close(): void
    {
        $this->offEkg();
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
     * 打开心电图
     */
    private function onEkg(): void
    {
        $this->ekgId = $this->reactor->setInterval($this->checkHeartbeatInterval, function () {
            $now = time();
            foreach ($this->connections as $connection) {
                if ($connection->heartbeatTime + $this->heartbeatTimeout < $now) {
                    $connection->close();
                }
            }
        });
    }

    /**
     * 关闭心电图
     */
    private function offEkg(): void
    {
        if ($this->ekgId > 0) {
            $this->reactor->delInterval($this->ekgId);
        }
    }
}
