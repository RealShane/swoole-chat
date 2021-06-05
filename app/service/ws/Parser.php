<?php

namespace app\service\ws;


class Parser
{

    /**
     * 编码
     * Encode output payload for websocket push.
     *
     * @param string $event
     * @param mixed $data
     *
     * @return mixed
     */
    public function encode(string $event, $data)
    {
        return json_encode(['event' => $event, 'data' => $data]);
    }

    /**
     * 解码
     * Decode message from websocket client.
     * Define and return payload here.
     *
     * @param \Swoole\Websocket\Frame $frame
     *
     * @return array
     */
    public function decode($frame)
    {
        $payload = Packet::getPayload($frame->data);
        return [
            'event' => $payload['event'] ?? null,
            'data' => $payload['data'] ?? null,
        ];
    }


}
