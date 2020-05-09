Yii2 Lemon Way Payments Integration
================================
Yii2 Lemon Way Payments Integration

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist kowi/yii2-lemon "*"
```

or add

```
"kowi/yii2-lemon": "*"
```

to the require section of your `composer.json` file.


Configuration
-------------

Once the extension is installed, simply config it in your application:

```php
<?php

return [
    'components' => [
        'lemonway' => [
            'class' => 'kowi\lemon\Lemonway',
            'apiBaseUrl' => 'https://sandbox-api.lemonway.fr/mb/kowi/dev/directkitrest',
            'apiAuthUrl' => 'https://sandbox-api.lemonway.fr/oauth/api/v1/oauth/token',
            'newApiKeyPath' => '@app/runtime/accessToken.json',
            'apiKey' =>'0fab3b41-1234-abcd-xyz1-29660f5767a9',
        ],
    ]
];
```

Usage
-------------

```php

use kowi\lemon\objects\Adresse;
use kowi\lemon\objects\Birth;
use kowi\lemon\resources\AccountIndividual;

$adresse = new Adresse();
$adresse->street = '26 rue de Paris';
$adresse->postCode = '93100';
$adresse->city = 'Montreuil';
$adresse->country = 'FRA';

$birth = new Birth();
$birth->date = '1985/03/21';
$birth->city = 'Montreuil';
$birth->Country = 'FRA';

$account = new AccountIndividual();
$account->accountId = '2';
$account->email = 'ymartinez@sicma21.com';
$account->title = 'M';
$account->firstName = 'Adrian';
$account->lastName = 'Martinez Duque';
$account->adresse = $adresse;
$account->birth = $birth;
$account->nationality = 'CUB';
$account->phoneNumber = '5342492852';
$account->mobileNumber = '5342492852';
$account->payerOrBeneficiary = 1;

if ($account->save()) {
    // code is save
} else {
    // code is not save
}
```
