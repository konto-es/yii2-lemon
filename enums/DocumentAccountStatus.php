<?php

namespace kowi\lemon\enums;

use yii2mod\enum\helpers\BaseEnum;

class DocumentAccountStatus extends BaseEnum
{
    const REGISTERED_KYC_INCOMPLETE = 2;
    const REGISTERED_REJECTED_KYC = 3;
    const REGISTERED_KYC_1 = 5;
    const REGISTERED_KYC_2 = 6;
    const REGISTERED_KYC_3 = 7;
    const REGISTERED_EXPIRED_KYC = 8;
    const BLOCKED = 10;
    const CLOSED = 12;
    const REGISTERED_FROM_KYC_2_TO_KYC_3 = 13;
    const ONE_TIME_CUSTOMER = 14;
    const SPECIAL_ACCOUNT_FOR_CROWDLENDING = 15;
    const TECHNICAL_ACCOUNT = 16;

    /**
     * @var array
     */
    public static $list = [
        self::REGISTERED_KYC_INCOMPLETE => 'Registered, KYC incomplete',
        self::REGISTERED_REJECTED_KYC => 'Registered, rejected KYC',
        self::REGISTERED_KYC_1 => 'Registered, KYC 1 (status given at registration).',
        self::REGISTERED_KYC_2 => 'Registered, KYC 2.',
        self::REGISTERED_KYC_3 => 'Registered, KYC 3.',
        self::REGISTERED_EXPIRED_KYC => 'Registered, expired KYC.',
        self::BLOCKED => 'Blocked.',
        self::CLOSED => 'Closed',
        self::REGISTERED_FROM_KYC_2_TO_KYC_3 => 'Registered, status is being updated from KYC 2 to KYC 3.',
        self::ONE_TIME_CUSTOMER => 'One-time customer.',
        self::SPECIAL_ACCOUNT_FOR_CROWDLENDING => 'Special account for crowdlending.',
        self::TECHNICAL_ACCOUNT => 'Technical account.',
    ];
}