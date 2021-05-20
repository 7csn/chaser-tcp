<?php

namespace chaser\tcp;

use chaser\stream\interfaces\ConnectionInterface;
use chaser\stream\interfaces\parts\NetworkAddressInterface;

/**
 * tcp 连接接口
 *
 * @package chaser\tcp
 */
interface TcpConnectionInterface extends ConnectionInterface, NetworkAddressInterface
{
    /**
     * 默认心跳（收到新的完整请求）时间间隔上限（秒）
     */
    public const HEARTBEAT_TIMEOUT = 55;
}
