<?php

namespace app\controllers;

use kowi\lemon\objects\Adresse;
use kowi\lemon\objects\Birth;
use kowi\lemon\resources\AccountIndividual;
use kowi\lemon\resources\Iban;
use yii\console\Controller;

/**
 * Class DefaultController
 * @package app\controllers
 */
class DefaultController extends Controller
{
    public function actionIndex()
    {
        $iban = new Iban();
        $iban->accountId = '2';
        $iban->holder = 'JEAN DUPONT';
        $iban->iban = 'FR1420041010050500013M02606';

        if (!$iban->insert()) {
            print_r($iban->getErrors());
        } else {
            print_r($iban->attributes);
        }
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