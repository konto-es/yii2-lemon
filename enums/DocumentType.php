<?php


namespace kowi\lemon\enums;

use yii2mod\enum\helpers\BaseEnum;

class DocumentType extends BaseEnum
{
    const ID_CARD = 0;
    const PROOF_OF_ADDRESS = 1;
    const SCAN_OF_A_PROOF_OF_IBAN = 2;
    const PASSPORT_EU = 3;
    const PASSPORT = 4;
    const RESIDENCE_PERMIT = 5;
    const OFFICIAL_COMPANY_REGISTRATION_DOCUMENT = 7;
    const DRIVER_LICENCE = 11;
    const STATUS = 12;
    const SELFIE = 13;
    const OTHERS = 14;
    const SDD_MANDATE = 21;

    /**
     * @var array
     */
    public static $list = [
        self::ID_CARD => 'ID card (both sides in one file)',
        self::PROOF_OF_ADDRESS => 'Proof of address',
        self::SCAN_OF_A_PROOF_OF_IBAN => 'Scan of a proof of IBAN',
        self::PASSPORT_EU => 'Passport (European Union)',
        self::PASSPORT => 'Passport (outside the European Union)',
        self::RESIDENCE_PERMIT => 'Residence permit (both sides in one file)',
        self::OFFICIAL_COMPANY_REGISTRATION_DOCUMENT => 'Official company registration document (Kbis extract or equivalent)',
        self::DRIVER_LICENCE => 'Driver licence (both sides in one file)',
        self::STATUS => 'Status',
        self::SELFIE => 'Selfie',
        self::OTHERS => 'Others',
        self::SDD_MANDATE => 'SDD mandate',
    ];
}