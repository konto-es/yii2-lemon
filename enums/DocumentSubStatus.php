<?php


namespace kowi\lemon\enums;

use yii2mod\enum\helpers\BaseEnum;

class DocumentSubStatus extends BaseEnum
{
    const DOCUMENT_TYPE_NOT_PROCESSABLE_AUTOMATICALLY = 1;
    const UNREADABLE_BY_COMPUTER = 2;
    const WRONG_TYPE = 3;
    const WRONG_NAME = 4;
    const FILE_TOO_BIG = 5;
    const AUTOMATIC_CONTROLS_FAILED = 6;
    const NEED_2_SIDES_OF_THE_DOCUMENT_IN_ONE_FILE = 7;
    const UNKNOWN = 8;

    /**
     * @var array
     */
    public static $list = [
        self::DOCUMENT_TYPE_NOT_PROCESSABLE_AUTOMATICALLY => 'Document type not processable automatically.',
        self::UNREADABLE_BY_COMPUTER => 'Unreadable by computer (Cropped, blur, glare…).',
        self::WRONG_TYPE => 'Wrong Type.',
        self::WRONG_NAME => 'Wrong Name (Name not matching user information).',
        self::FILE_TOO_BIG => 'File too big (File is over 4MB).',
        self::AUTOMATIC_CONTROLS_FAILED => 'Automatic Controls Failed.',
        self::NEED_2_SIDES_OF_THE_DOCUMENT_IN_ONE_FILE => 'Need 2 sides of the document in one file.',
        self::UNKNOWN => 'Unknown',
    ];
}