<?php

declare(strict_types=1);

namespace chaser\tcp\subscriber;

use chaser\stream\event\{Established, Message};
use chaser\stream\subscriber\ConnectionSubscriber as TcpConnectionSubscriber;
use chaser\tcp\Connection;

/**
 * tcp 连接事件订阅类
 *
 * @package chaser\tcp\subscriber
 *
 * @property Connection $connection
 */
class ConnectionSubscriber extends TcpConnectionSubscriber
{
    /**
     * @inheritDoc
     */
    public function established(Established $event): void
    {
        $this->connection->heartbeat();
    }

    /**
     * @inheritDoc
     */
    public function message(Message $event): void
    {
        $this->connection->heartbeat();
    }
}
