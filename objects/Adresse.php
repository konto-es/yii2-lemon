<?php

namespace kowi\lemonway\objects;

use yii\base\Model;

/**
 * Class Adresse
 * @package kowi\lemonway\objects
 */
class Adresse extends Model
{
    /** @var string CLIENT number and street. */
    public $street;
    /** @var string CLIENT post code/ZIP. */
    public $postCode;
    /** @var string CLIENT city. */
    public $city;
    /** @var string CLIENT country using ISO 3166-1 alpha-3. */
    public $country;

    public function rules()
    {
        return array_merge(parent::rules(), [
            /** @see https://apidoc.lemonway.com/#operation/Accounts_IndividualPut */
            [['country'], 'required'],
            [['country'], 'string', 'length' => 3],
            [['street'], 'string', 'max' => 256],
            [['postCode'], 'string', 'max' => 10],
            [['city'], 'string', 'max' => 140],
        ]);
    }

}