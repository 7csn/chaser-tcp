<?php

namespace chaser\tcp;

use chaser\stream\subscribers\ConnectedClientSubscriber;

/**
 * tcp 客户端事件订阅类
 *
 * @package chaser\tcp
 *
 * @property TcpClient $client
 */
class TcpClientSubscriber extends ConnectedClientSubscriber
{
}
