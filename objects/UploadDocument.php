<?php


namespace kowi\lemon\objects;

use kowi\lemon\enums\DocumentAccountStatus;
use kowi\lemon\enums\DocumentStatus;
use kowi\lemon\enums\DocumentSubStatus;
use yii\base\Model;

/**
 * Class UploadDocument
 * @package kowi\lemon\resources
 */
class UploadDocument extends Model
{
    /**
     * @var integer ID of the document.
     */
    public $id;
    /**
     * @var integer Status of the document:
     * 0 = Document put on hold, waiting for another document.
     * 1 = Received, need manual validation.
     * 2 = Accepted.
     * 3 = Rejected.
     * 4 = Rejected. Unreadable by human (Cropped, blur, glare…).
     * 5 = Rejected. Expired (Expiration Date is passed).
     * 6 = Rejected. Wrong Type (Document not accepted).
     * 7 = Rejected. Wrong Name (Name not matching user information).
     */
    public $status;
    /**
     * @var integer Sub status of the document. Only when Status = 1:
     * 1 = Document type not processable automatically.
     * 2 = Unreadable by computer (Cropped, blur, glare…).
     * 3 = Wrong Type.
     * 4 = Wrong Name (Name not matching user information).
     * 5 = File too big (File is over 4MB).
     * 6 = Automatic Controls Failed.
     * 7 = Need 2 sides of the document in one file.
     * 8 = Unknown.
     */
    public $substatus;
    /**
     * @var integer Status of the Payment account.
     * 2 = Registered, KYC incomplete.
     * 3 = Registered, rejected KYC.
     * 5 = Registered, KYC 1 (status given at registration).
     * 6 = Registered, KYC 2.
     * 7 = Registered, KYC 3.
     * 8 = Registered, expired KYC.
     * 10 = Blocked.
     * 12 = Closed.
     * 13 = Registered, status is being updated from KYC 2 to KYC 3.
     * 14 = One-time customer.
     * 15 = Special account for crowdlending.
     * 16 = Technical account.
     */
    public $accountstatus;

    /**
     * Rules established according to the documentation
     *
     * @see https://apidoc.lemonway.com/
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['id'], 'integer'],
            [['status'], 'in', 'range' => DocumentStatus::getConstantsByName()],
            [['substatus'], 'in', 'range' => DocumentSubStatus::getConstantsByName()],
            [['accountstatus'], 'in', 'range' => DocumentAccountStatus::getConstantsByName()],
        ]);
    }

    public function getStatusLabel()
    {
        return DocumentStatus::getLabel($this->status);
    }

    public function getSubStatusLabel()
    {
        return DocumentSubStatus::getLabel($this->substatus);
    }

    public function getAccountStatusLabel()
    {
        return DocumentAccountStatus::getLabel($this->accountstatus);
    }
}