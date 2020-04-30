<?php

namespace app\controllers;

use kowi\lemonway\objects\Adresse;
use kowi\lemonway\objects\Birth;
use kowi\lemonway\resources\AccountIndividual;
use Yii;
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
     */
    public function actionIndex()
    {
        $adresse = new Adresse();
        $adresse->street ='26 rue de Paris';
        $adresse->postCode ='93100';
        $adresse->city ='Montreuil';
        $adresse->country ='FRA';

        $birth = new Birth();
        $birth->date='1985/03/21';
        $birth->city='Montreuil';
        $birth->Country='FRA';

        $account = new AccountIndividual();
        $account->accountId ='2';
        $account->email ='ymartinez@sicma21.com';
        $account->title = 'M';
        $account->firstName = 'yusney';
        $account->lastName = 'martinez duque';
        $account->adresse = $adresse;
        $account->birth =$birth ;

        $account->nationality = 'CUB';
        $account->phoneNumber = '632613251';
        $account->mobileNumber = '632613251';
        $a=$account->insert();
        var_dump($account->getErrors());
    }
}