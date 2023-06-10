<?php
return [
    'services' => [
        'youtube' => [
            'redirect_endpoint' => 'https://accounts.google.com/o/oauth2/v2/auth',
            'request_token_endpoint' => 'https://oauth2.googleapis.com/token',
            'redirect_params' => 'include_granted_scopes=true&access_type=offline&response_type=code&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fyoutube+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fyoutube.channel-memberships.creator+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fyoutube.force-ssl+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fyoutube.readonly+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fyoutube.upload+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fyoutubepartner+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fyoutubepartner-channel-audit&auth_type=rerequest&config_id=546398514232015',
            'request_token_params' => 'access_type=offline&grant_type=authorization_code',
            'refresh_token_params' => 'access_type=offline&grant_type=refresh_token',
            'client_id' => env('YOUTUBE_CLIENT_ID', '1093101282496-jhqbs0njj03lj1117vpee80h6m7v73sc.apps.googleusercontent.com'),
            'client_secret' => env('YOUTUBE_CLIENT_SECRET', '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'),
            'api_prefix' => 'https://youtube.googleapis.com/',
            'post_configuration_required' => false,            
            'endpoints' => [
                // 'shop' => ['list_endpoint' => 'youtube/v3/channels/', 'get_endpoint' => '/{id}'], // get accounts - pages
                'shop' => ['list_endpoint' => ['endpoint' =>'/youtube/v3/channels', 'params' => ['part'=>'snippet', 'contentDetails' => 'statistics', 'mine' => 'true']]],
            ]
        ]
    ]
];