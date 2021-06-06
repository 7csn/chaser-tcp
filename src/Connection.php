<?php

declare(strict_types=1);

namespace chaser\tcp;

use chaser\stream\Connection as StreamConnection;
use chaser\stream\interfaces\part\NetworkAddressInterface;
use chaser\stream\traits\NetworkAddress;

/**
 * tcp 连接
 *
 * @package chaser\tcp
 */
class Connection extends StreamConnection implements NetworkAddressInterface
{
    use NetworkAddress;
}
