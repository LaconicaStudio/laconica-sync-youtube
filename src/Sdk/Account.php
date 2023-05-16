<?php

namespace Laconica\Sync\Youtube\Sdk;

class Account extends \Laconica\Sync\Core\Sdk\Resource
{
    public function getList($params = [])
    {
        $list = parent::getList($params);
        $result = [];

        if (empty($list) || !isset($list['items'])) {
            return $result;
        }

        foreach ($list['items'] as $item) {
            if (!($channelData = $item['snippet'])) {
                continue;
            }

            if (empty($item['id']) || empty($channelData['title'])) {
                continue;
            }

            $thumbnail = '';
            if (!empty($channelData['thumbnails'])) {
                $thumbnail = $channelData['thumbnails']['medium']['url'] ?? $channelData['thumbnails']['default']['url'] ?? '';
            }

            $result[] = ['id' => $item['id'], 'name' => $channelData['title'], 'picture' => $thumbnail ]; 
        }

        return $result;
    }
}