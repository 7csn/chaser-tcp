<?php

namespace chaser\tcp;

use chaser\stream\interfaces\ConnectedClientInterface;
use chaser\stream\interfaces\parts\NetworkAddressInterface;

/**
 * tcp 客户端接口
 *
 * @package chaser\tcp
 */
interface TcpClientInterface extends ConnectedClientInterface, NetworkAddressInterface
{
}
