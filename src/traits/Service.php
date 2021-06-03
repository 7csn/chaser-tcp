<?php

declare(strict_types=1);

namespace chaser\tcp\traits;

use chaser\stream\interfaces\part\ServiceInterface;

/**
 * tcp 服务特征
 *
 * @package chaser\tcp\traits
 *
 * @see ServiceInterface
 */
trait Service
{
    /**
     * @inheritDoc
     */
    public static function transport(): string
    {
        return 'tcp';
    }

    /**
     * 套接字流设置
     */
    protected function socketSettings(): void
    {
        if (function_exists('socket_import_stream')) {
            // 转化底层 socket
            $socket = socket_import_stream($this->socket);
            // 开启连接状态检测
            socket_set_option($socket, SOL_SOCKET, SO_KEEPALIVE, 1);
            // 禁用 tcp 的 Nagle 算法，允许小包数据发送
            socket_set_option($socket, SOL_TCP, TCP_NODELAY, 1);
        }
    }
}
