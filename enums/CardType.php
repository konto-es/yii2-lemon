<?php


namespace kowi\lemon\enums;

use yii2mod\enum\helpers\BaseEnum;

class CardType extends BaseEnum
{
    const CB = 0;
    const VISA = 1;
    const MASTERCARD = 2;

    /**
     * @var array
     */
    public static $list = [
        self::CB => 'CB',
        self::VISA => 'Visa',
        self::MASTERCARD => 'Mastercard',
    ];

}