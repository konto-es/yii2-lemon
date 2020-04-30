<?php

namespace kowi\lemonway\objects;

use yii\base\Model;

class Birth extends Model
{
    /** @var string CLIENT Birthdate. */
    public $date;
    /** @var string CLIENT city of birth. */
    public $city;
    /** @var string CLIENT country of birth, using ISO 3166-1 alpha-3. */
    public $Country;

    public function rules()
    {
        return array_merge(parent::rules(), [
            /** @see https://apidoc.lemonway.com/#operation/Accounts_IndividualPut */
            [['date'], 'required'],
            [['date'], 'match', 'pattern' => '^[12]\d{3}\/(0[1-9]|1[0-2])\/(0[1-9]|[12]\d|3[01])$'],
            [['city'], 'string', 'max' => 140],
            [['Country'], 'string', 'length' => 3],
        ]);
    }
}