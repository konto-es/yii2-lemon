<?php


namespace kowi\lemon\enums;

use yii2mod\enum\helpers\BaseEnum;

class DocumentStatus extends BaseEnum
{
    const DOCUMENT_PUT_ON_HOLD = 0;
    const RECEIVED = 1;
    const ACCEPTED = 2;
    const REJECTED = 3;
    const REJECTED_UNREADABLE_BY_HUMAN = 4;
    const REJECTED_EXPIRED = 5;
    const REJECTED_WRONG_TYPE = 6;
    const REJECTED_WRONG_NAME = 7;

    /**
     * @var array
     */
    public static $list = [
        self::DOCUMENT_PUT_ON_HOLD => 'Document put on hold, waiting for another document',
        self::RECEIVED => 'Received, need manual validation',
        self::ACCEPTED => 'Accepted',
        self::REJECTED => 'Rejected',
        self::REJECTED_UNREADABLE_BY_HUMAN => 'Rejected. Unreadable by human (Cropped, blur, glare…)',
        self::REJECTED_EXPIRED => 'Rejected. Expired (Expiration Date is passed)',
        self::REJECTED_WRONG_TYPE => 'Rejected. Wrong Type (Document not accepted)',
        self::REJECTED_WRONG_NAME => 'Rejected. Wrong Name (Name not matching user information)',
    ];
}