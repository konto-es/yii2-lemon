<?php


namespace kowi\lemon\enums;

use yii2mod\enum\helpers\BaseEnum;

class IbanStatus extends BaseEnum
{
    const NONE = 1;
    const INTERNAL = 2;
    const NOT_USED = 3;
    const WAITING_TO_BE_VERIFIED = 4;
    const ACTIVATED = 5;
    const REJECTED_BY_THE_BANK = 6;
    const REJECTED_NO_OWNER = 7;
    const DEACTIVATED = 8;
    const REJECTED = 9;

    /**
     * @var array
     */
    public static $list = [
        self::NONE => 'None',
        self::INTERNAL => 'Internal',
        self::NOT_USED => 'Not used',
        self::WAITING_TO_BE_VERIFIED => 'Waiting to be verified by Lemon Way',
        self::ACTIVATED => 'Activated',
        self::REJECTED_BY_THE_BANK => 'Rejected by the bank',
        self::REJECTED_NO_OWNER => 'Rejected, no owner',
        self::DEACTIVATED => 'Deactivated',
        self::REJECTED => 'Rejected',
    ];
}