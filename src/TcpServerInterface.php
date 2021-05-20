<?php

namespace chaser\tcp;

use chaser\stream\interfaces\ConnectedServerInterface;

/**
 * tcp 服务器接口
 *
 * @package chaser\tcp
 */
interface TcpServerInterface extends ConnectedServerInterface
{
    /**
     * 默认心跳（收到新的完整请求）检测时间间隔（秒）
     */
    public const CHECK_HEARTBEAT_INTERVAL = 10;
}
