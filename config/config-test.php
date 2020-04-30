<?php

return [
    'components' => [
        'lemonway' => [
            'class' => 'kowi\lemonway\Lemonway',
            'apiBaseUrl' => 'https://api-sandbox.payments.shasta.me/v1',
            'apiKey' => getenv('SHASTA_API_KEY'),
        ],
    ],
];
