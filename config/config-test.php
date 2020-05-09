<?php

return [
    'components' => [
        'lemonway' => [
            'class' => 'kowi\lemon\Lemonway',
            'apiBaseUrl' => 'https://sandbox-api.lemonway.fr/mb/kowi/dev/directkitrest',
            'apiAuthUrl' => 'https://sandbox-api.lemonway.fr/oauth/api/v1/oauth/token',
            'newApiKeyPath' => '@app/runtime/accessToken.json',
            'apiKey' => getenv('LEMON_API_KEY'),
        ],
    ],
];
