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

    public function _postConfiguration($token)
    {
        try {
            if (!isset($_GET['configuration'])) {
                $html = $this->_getAccountsLinks();
                return new AuthorizeResponse(AuthorizeResponse::STATUS_CONFIGURATION_REQUIRED, ['access_token' => $token],  null, $html);
            }

            return new AuthorizeResponse(AuthorizeResponse::STATUS_AUTHORIZED, ['access_token' => $token, 'ig-user-id' => urlencode($_GET['configuration'])]);
        } catch (\Exception $ex) {
            return new AuthorizeResponse(AuthorizeResponse::STATUS_UNAUTHORIZED, ['access_token' => $token], $ex->getMessage());
        }
    }

    protected function _getAccountsLinks()
    {
        $accountClient = $this->_getClient(null, 'account');
        $accounts = $accountClient->getInstagramList();
        
        if (empty($foundInstagramAccounts)) {
            throw new \Exception('No instagram account found.');
        }

        // prepare html for selecting account
        $html  = '<div class="instagram_accounts">';
        foreach ($foundInstagramAccounts as $account) {
            $html .= '<div><a href="?configuration='. urlencode($account['id']) .'&access_token='.$this->_authorizeRequest->getAccessToken().'">'. htmlspecialchars($account['name']) .'</a><div>';
        }

        $html .= '</div>';

        return $html;
    }
}