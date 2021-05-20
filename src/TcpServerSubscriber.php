<?php

namespace chaser\tcp;

use chaser\stream\events\ServerStart;
use chaser\stream\subscribers\ConnectedServerSubscriber;

/**
 * tcp 服务器事件订阅者
 *
 * @package chaser\tcp
 *
 * @property TcpServerInterface $server
 */
class TcpServerSubscriber extends ConnectedServerSubscriber
{
    /**
     * @inheritDoc
     */
    public function start(ServerStart $event): void
    {
        $this->server->heartbeatCheck();
    }
}
