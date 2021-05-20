<?php

namespace chaser\tcp;

use chaser\stream\events\Connect;
use chaser\stream\events\Message;
use chaser\stream\subscribers\ConnectionSubscriber;

/**
 * tcp 连接事件订阅类
 *
 * @package chaser\tcp
 *
 * @property TcpConnectionInterface $connection
 */
class TcpConnectionSubscriber extends ConnectionSubscriber
{
    /**
     * @inheritDoc
     */
    public function connect(Connect $event): void
    {
        $this->connection->setHeartbeatTime();
    }

    /**
     * @inheritDoc
     */
    public function message(Message $event): void
    {
        $this->connection->setHeartbeatTime();
    }
}
