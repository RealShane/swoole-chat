<?php
/**
 *
 * @description: 永远爱颍
 *
 * @author: Shane
 *
 * @time: 2021/6/5 20:25
 */


namespace app\service\ws;


class Packet
{

    /**
     * Get data packet from a raw payload.
     *
     * @param string $packet
     *
     * @return array|null
     */
    public static function getPayload(string $packet)
    {
        $packet = trim($packet);
        // 判断是否为json字符串
        $data = json_decode($packet, true);
        if (is_null($data)) {
            return;
        }
        return [
            'event' => $data['event'],
            'data' => $data['data'] ?? null,
        ];
    }

}