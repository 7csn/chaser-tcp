<?php

declare(strict_types=1);

namespace chaser\tcp\subscriber;

use chaser\stream\event\Start;
use chaser\stream\subscriber\ConnectedServerSubscriber;
use chaser\tcp\Server;

/**
 * tcp 服务器事件订阅者
 *
 * @package chaser\tcp\subscriber
 *
 * @property Server $server
 */
class ServerSubscriber extends ConnectedServerSubscriber
{
    /**
     * @inheritDoc
     */
    public function start(Start $event): void
    {
        $this->server->heartbeatMonitoring();
    }
}
