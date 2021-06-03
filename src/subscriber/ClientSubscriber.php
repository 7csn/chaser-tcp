<?php

declare(strict_types=1);

namespace chaser\tcp\subscriber;

use chaser\stream\subscriber\ConnectedClientSubscriber;
use chaser\tcp\Client;

/**
 * tcp 客户端事件订阅类
 *
 * @package chaser\tcp\subscriber
 *
 * @property Client $client
 */
class ClientSubscriber extends ConnectedClientSubscriber
{
}
