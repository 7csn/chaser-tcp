<?php

declare(strict_types=1);

namespace chaser\tcp;

use chaser\stream\ConnectedServer;
use chaser\stream\traits\ServerContext;

/**
 * tcp 服务器
 *
 * @package chaser\tcp
 */
class Server extends ConnectedServer
{
    use ServerContext, Service;

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
    protected function configureSocket(): void
    {
        $this->socketSettings();
        parent::configureSocket();
    }
}
