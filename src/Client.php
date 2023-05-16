<?php

namespace Laconica\Sync\Youtube;
use \Laconica\Sync\Core\Sdk\AuthorizeResponse;

class Client extends \Laconica\Sync\Core\Client
{
    const SCOPES = ['https://www.googleapis.com/auth/youtubepartner', 'https://www.googleapis.com/auth/youtube.upload', 'https://www.googleapis.com/auth/youtube', 'https://www.googleapis.com/auth/youtube.force-ssl'];
    
    public function _validateToken($tokenData)
    {
        if (!isset($tokenData['scope'])) {
            throw new \Exception('Authorization failed');
        }

        $scopes = explode(' ', $tokenData['scope']);
        $missingScopes = array_diff(self::SCOPES, $scopes);
        if (!empty($missingScopes)) {
            throw new \Exception('Authorization failed: required permissins have not been granted');
        }

        return true;
    }
}