<?php


namespace kowi\lemon\resources;


use kowi\lemon\objects\Card;

class ResgisterCard extends Resource
{
    public $id;
    /**
     * @var string $accountId string [ 0 .. 256 ] characters
     */
    public $accountId;

    /**
     * @var Card $card
     */
    public $card;

    public function rules()
    {
        return array_merge(parent::rules(), [
            /** @see https://apidoc.lemonway.com/#operation/MoneyIns_CardRegisterPost **/
            [['accountId', 'card'], 'required', 'on' => [static::SCENARIO_CREATE]],
        ]);
    }

    public static function resource()
    {
        return [
            static::SCENARIO_LOAD => '/v2/moneyins/{accountid}/card',
            static::SCENARIO_CREATE => '/v2/moneyins/card/register',
           // static::SCENARIO_UPDATE => '/v2/accounts/individual',
        ];
    }

}