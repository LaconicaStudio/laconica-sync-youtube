<?php
return [
    'services' => [
        'instagram' => [
            'redirect_endpoint' => 'https://www.facebook.com/v16.0/dialog/oauth',
            'request_token_endpoint' => 'https://graph.facebook.com/v16.0/oauth/access_token',
            'token_information_endpoint' => 'https://www.facebook.com/v16.0/dialog/oauth/access_token',
            'mode' => env('SHOPIFY_MODE', 'development'),
            'redirect_params' => 'response_type=code&display=popup&auth_type=rerequest&config_id=546398514232015',
            'client_id' => env('INSTAGRAM_CLIENT_ID', '756792042590706'),
            'client_secret' => env('INSTAGRAM_CLIENT_SECRET', 'e677c907fd4b2d46de70a8e444448e0d'),
            'configuration_id' => env('INSTAGRAM_CONFIGURATION_ID', '546398514232015'), // TODO: use this setting instead from hardcode
             // 'scopes' => 'instagram_basic,pages_show_list,public_profile',
            'api_prefix' => 'https://graph.facebook.com/v16.0/',
            'post_configuration_required' => true,
            'token_type' => 'param',
            
            'endpoints' => [
                'shop' => ['list_endpoint' => '/me/accounts/', 'get_endpoint' => '/{id}'], // get accounts - pages
                'post' => ['create_endpoint' => [ // https://developers.facebook.com/docs/instagram-api/guides/content-publishing/
                                                'create' => ['endpoint' =>'/{ig-user-id}/media'], 
                                                'post' => ['endpoint' =>'/{ig-user-id}/media_publish', 'params' => ['creation_id' => '{response.id}']]
                                                ]
                ]
            ]
        ]
    ]
];