<?php

namespace app\controllers;

use kowi\lemon\objects\Adresse;
use kowi\lemon\objects\Birth;
use kowi\lemon\objects\Card;
use kowi\lemon\resources\AccountIndividual;
use kowi\lemon\resources\ResgisterCard;
use yii\base\InvalidConfigException;
use yii\console\Controller;
use yii\httpclient\Exception;

/**
 * Class ShastaController
 * @package ddroche\shasta\controllers
 */
class DefaultController extends Controller
{
    /**
     * @see https://doc.payments.shasta.me/
     *
     * 1- Create Project
     * 2- Create Customer in Project
     * 3- Create Bank Account for Customer in Project
     * 4- Create Account for Customer in Project
     * 5- Create Bank Payin References
     * 6- Create Bank Payins
     * 7- Create Transfer
     *
     * @throws Exception
     * @throws InvalidConfigException
     * @throws \http\Exception
     */
    public function actionIndex()
    {
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
        $account->firstName = 'adrian';
        $account->lastName = 'martinez duque';
        $account->adresse = $adresse;
        $account->birth = $birth;

        $account->nationality = 'CUB';
        $account->phoneNumber = '5342492852';
        $account->mobileNumber = '5342492852';
        $account->payerOrBeneficiary = 1;
//---------------regitrar tarjeta
        $card = new Card();
        $card->cardType = 1;
        $card->cardNumber = '4716202982346875';
        $card->cardCode = '123';
        $card->cardDate = '05/2022';

        $registerCard = new ResgisterCard();
        $registerCard->accountId = 1;
        $registerCard->card=$card;

        //$registerCard->save();
        //$a = ResgisterCard::findOne(1);
        // $account->save();
        $a = AccountIndividual::findOne('5');
        // $a->adresse->street='calle cuba';
        //$a->save();

        var_dump($a);
    }
}