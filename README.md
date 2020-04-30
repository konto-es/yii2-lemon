Yii2 Shasta Payments Integration
================================
Yii2 Shasta Payments Integration

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist kowi/yii2-lemonway "*"
```

or add

```
"kowi/yii2-lemonway": "*"
```

to the require section of your `composer.json` file.


Configuration
-------------

Once the extension is installed, simply config it in your application:

```php
<?php

return [
    'components' => [
        'shasta' => [
            'class' => 'kowi\yii2-lemonway\Lemonway',
            // Develop Enviroment
            'apiEndPoint' => 'https://api-sandbox.payments.shasta.me/v1',
            // Production Enviroment
            'apiEndPoint' => 'https://api.payments.shasta.me/v1',
            // Your Production or Development Enviroment API Key
            'apiKey' => 'Bearer key_...',
        ],
    ]
];
```

Usage
-------------

```php
$address = new ddroche\shasta\resources\Address();
$address->line_1 = 'Avenida Omejos, 5';
$address->line_2 = 'Atico 2a';
$address->postal_code = '08291';
$address->city = "L'Hospitalet de Llobregat";
$address->region = 'Barcelona';
$address->country = 'ES';

$customer = new ddroche\shasta\resources\Customer();
$customer->first_name = 'Javier';
$customer->last_name = 'Hernandez';
$customer->email_address = 'javi@example.com';
$customer->phone_number = '123456789';
$customer->nationality = 'ES';
$customer->employment_status = 'self_employed';
$customer->address = $address;

if ($customer->save()) {
    // code is save
} else {
    // code is not save
}
```

Class Resources whit functions
-----
```
Project (GET, SET)
Accounts (All, Create, Read, Update)
Transactions (All, allAccountsTransactions, Read)
Customers (All, Create, Read, Update)
Transfers (All, Create, Read, Update)
CardTokens (Create, Read)
Cards (All, Create, Read, Update)
CardPayins (All, Create, Read, Update, Finish)
CardPayinsRefunds (All, Create, Read, Update)
CardVerifications (All, Create, Read, Update, Finish)
BankAccounts (All, Create, Read, Update)
BankPayinReferences (All, Create, Read, Update)
BankPayins (All, Read, Update)
BankPayout (All, Create, Read, Update)
```
