<?php

namespace app\service\ws;

use Swoole\Server;
use Swoole\Websocket\Frame;
use Swoole\WebSocket\Server as WebsocketServer;
use think\Config;
use think\Request;

class Handler
{
    /** @var WebsocketServer */
    protected $server;

    /** @var Config */
    protected $config;

    public function __construct(Server $server, Config $config)
    {
        $this->server = $server;
        $this->config = $config;
    }

    /**
     * "onOpen" listener.
     *
     * @param int $fd
     * @param Request $request
     */
    public function onOpen($fd, Request $request)
    {
        if (!$request->param('sid')) {
            $payload = json_encode(
                [
                    'event' => 'connectok',
                    'data' => [
                        'sid' => base64_encode(uniqid()),
                        'upgrades' => [],
                        'pingInterval' => $this->config->get('swoole.websocket.ping_interval'),
                        'pingTimeout' => $this->config->get('swoole.websocket.ping_timeout'),
                    ]
                ]
            );
            $this->server->push($fd, $payload);
        }
    }

    /**
     * "onMessage" listener.
     *  only triggered when event handler not found
     *
     * @param Frame $frame
     * @return bool
     */
    public function onMessage(Frame $frame)
    {
        $packet = $frame->data;
        if (Packet::getPayload($packet)) {
            return false;
        }

        // 判断是否是心跳包
        if ($packet === 'ping') {
            $this->server->push($frame->fd, 'pong');
        }

        return true;
    }

    /**
     * "onClose" listener.
     *
     * @param int $fd
     * @param int $reactorId
     */
    public function onClose($fd, $reactorId)
    {
        return;
    }


}
