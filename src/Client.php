<?php

namespace Laconica\Sync\Instagram;
use \Laconica\Sync\Core\Sdk\AuthorizeResponse;

class Client extends \Laconica\Sync\Core\Client
{
    protected $_postConfigurationRequired = true;

    public function isAuthorized()
    {
        if (!parent::isAuthorized()) {
            return false;
        }

        $connectionData = $this->getConnectionData();
        $settings = $connectionData['setting'] ?? [];
        return !empty($settings['ig-user-id']);
    }

    public function _postConfiguration()
    {
        try {
            if (!isset($_GET['configuration'])) {
                $html = $this->_getAccountsLinks();
                return new AuthorizeResponse(AuthorizeResponse::STATUS_CONFIGURATION_REQUIRED, null, $html);
            }

            // configuration found, saving details
            $connectionData = $this->getConnectionData();
            $settings = $connectionData['setting'] ?? [];
            $settings['ig-user-id'] = urlencode($_GET['configuration']);
            $this->setConnectionData($settings);

            return new AuthorizeResponse(AuthorizeResponse::STATUS_AUTHORIZED);
        } catch (\Exception $ex) {echo $ex->getMessage();
            return new AuthorizeResponse(AuthorizeResponse::STATUS_UNAUTHORIZED, $ex->getMessage());
        }
    }

    protected function _getAccountsLinks()
    {
        $accountClient = $this->_getClient(null, 'account');
        $accounts = $accountClient->getList();
        if (empty($accounts)) {
            throw new \Exception('No pages found in your account.');
        }

        $foundInstagramAccounts = [];
        foreach ($accounts as $account) {
            if (!isset($account['id']) || !isset($account['name'])) {
                continue;
            }


            // 'fields=instagram_business_account
            $accountDetails = $accountClient->get($account['id'], ['fields' => 'instagram_business_account']);
            $instagramAccount = $accountDetails->getInstagramBusinessAccount() ?? null;
            if (empty($instagramAccount) || empty($instagramAccount['id'])) {
                continue;
            }

            $details = $accountClient->get($instagramAccount['id'], ['fields' => 'name']);
            $foundInstagramAccounts[] = ['name' => $details->getName(), 'id' => $details->getId()];
        }
        
        if (empty($foundInstagramAccounts)) {
            throw new \Exception('No instagram account found.');
        }

        // prepare html for selecting account
        $html  = '<div class="instagram_accounts">';
        foreach ($foundInstagramAccounts as $account) {
            $html .= '<div><a href="?configuration='. urlencode($account['id']) .'">'. htmlspecialchars($account['name']) .'</a><div>';
        }

        $html .= '</div>';

        return $html;
    }
}