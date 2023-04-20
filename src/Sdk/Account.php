<?php

namespace Laconica\Sync\Instagram\Sdk;

class Account extends \Laconica\Sync\Core\Sdk\Resource
{
    public function getList($params = [])
    {
        $list = parent::getList($params);
        $result = [];

        if (empty($list) || !isset($list['data'])) {
            return $result;
        }

        foreach ($list['data'] as $account) {
            if (empty($account['id']) || empty($account['name'])) {
                continue;
            }

            $result[] = ['id' => $account['id'], 'name' => $account['name']]; 
        }

        return $result;
    }
}