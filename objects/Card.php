<?php


namespace kowi\lemon\objects;

use kowi\lemon\enums\CardType;
use kowi\lemon\resources\Resource;
use yii\base\Model;

class Card extends Model
{
    public $id;
    /**
     * @var integer $cardType Card Type. 0 = CB. 1 = Visa. 2 = Mastercard.
     */
    public $cardType;

    /**
     * @var string $cardNumber Card Number.
     */
    public $cardNumber;

    /**
     * @var string $cardCode CVV Code at the back of the card.
     */
    public $cardCode;

    /**
     * @var string $cardDate Card expiration date.
     */
    public $cardDate;

    public $is3DS;
    public $country;
    public $authorizationNumber;
    public $maskedNumber;
    public $expiration;
    public $type;

    public function rules()
    {
        return array_merge(parent::rules(), [
            /** @see https://apidoc.lemonway.com/#operation/MoneyIns_CardRegisterPost **/
            [['cardType', 'cardNumber', 'cardCode', 'cardDate'], 'required', 'on' => [Resource::SCENARIO_CREATE] ],
            [['cardNumber'], 'string', 'min' => 13, 'max' => 19],
            [['cardCode'], 'string', 'length' => 3],
            [['cardType'], 'in', 'range' => CardType::getConstantsByName()],
            [[
                'id',
                'is3DS',
                'country',
                'authorizationNumber',
                'maskedNumber',
                'expiration',
                'type'
            ], 'safe', 'on' => [Resource::SCENARIO_LOAD]],
        ]);
    }

}