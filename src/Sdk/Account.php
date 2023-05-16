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

    public function getInstagramList($params = [])
    {
        $accounts = $this->getList($params);
        $foundInstagramAccounts = [];
        foreach ($accounts as $account) {
            if (!isset($account['id']) || !isset($account['name'])) {
                continue;
            }

            $accountDetails = $this->get($account['id'], ['fields' => 'instagram_business_account']);
            $instagramAccount = $accountDetails->getInstagramBusinessAccount() ?? null;
            if (empty($instagramAccount) || empty($instagramAccount['id'])) {
                continue;
            }

            $details = $this->get($instagramAccount['id'], ['fields' => 'name,profile_picture_url']);
            $foundInstagramAccounts[] = ['name' => $details->getName(), 'id' => $instagramAccount['id'], 'picture' => $details->getProfilePictureUrl()];
        }

        return $foundInstagramAccounts;
    }
}