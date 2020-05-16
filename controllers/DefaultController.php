<?php

namespace app\controllers;

use kowi\lemon\objects\Adresse;
use kowi\lemon\objects\Birth;
use kowi\lemon\resources\AccountIndividual;
use kowi\lemon\resources\Iban;
use kowi\lemon\resources\MoneyOut;
use yii\console\Controller;

/**
 * Class DefaultController
 * @package app\controllers
 */
class DefaultController extends Controller
{
    public function actionIndex()
    {
        $out = new MoneyOut();
        $out->accountId = '2';
        $out->ibanId = 9;
        $out->totalAmount = 1500;
        $out->commissionAmount = 300;
        $out->autoCommission = false;
        if (!$out->insert()) {
            echo 'ERROR';
            print_r($out->getErrors());
        } else {
            echo 'OK';
            print_r($out->attributes);
        }
        return;

        $iban = new Iban();
        $iban->accountId = '2';
        $iban->holder = 'JEAN DUPONT';
        $iban->iban = 'FR1420041010050500013M02606';

        if (!$iban->insert()) {
            print_r($iban->getErrors());
        } else {
            print_r($iban->attributes);
        }

        print_r(Iban::findAllIbans('2')[0]->attributes);
        return;
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
        $account->email = 'ymartinez@gmail.com';
        $account->title = 'M';
        $account->firstName = 'Adrian';
        $account->lastName = 'Martinez Duque';
        $account->adresse = $adresse;
        $account->birth = $birth;

        $account->nationality = 'CUB';
        $account->phoneNumber = '5342492852';
        $account->mobileNumber = '5342492852';
        $account->payerOrBeneficiary = 1;
        //print_r($account->toArray());
        if (!$account->insert()) {
            print_r($account->getErrors());

            print_r(AccountIndividual::findOne('2')->attributes);
        }
    }
}