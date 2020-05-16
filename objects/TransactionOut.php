<?php

namespace kowi\lemon\objects;

use yii\base\Model;

/**
 * Class TransactionOut
 * @package kowi\lemon\resources
 */
class TransactionOut extends Model
{
    /**
     * @var string Debited account
     */
    public $senderAccountId;
    /**
     * @var integer Debited amount. Amounts are given as integer numbers in cents.
     */
    public $debitAmount;
    /**
     * @var integer Iban Id
     */
    public $IbanId;
    /**
     * @var string bankStatus
     */
    public $maskedLabel;
    /**
     * @var string
     */
    public $bankStatus;
    /**
     * @var PSP
     */
    public $PSP;
    /**
     * @var integer ID of the money-in that caused the chargeback.
     */
    public $originId;
    /**
     * @var integer Transaction ID.
     */
    public $id;
    /**
     * @var integer Date of canceled MONEY-IN, UTC Unix timestamp. ,
     */
    public $date;
    /**
     * @var integer WHITE BRAND fee. Amounts are given as integer numbers in cents.
     */
    public $commissionAmount;
    /**
     * @var string Comment
     */
    public $comment;
    /**
     * @var integer Non used in WHITE BRAND KIT.
     */
    public $status;
    /**
     * @var LemonWayCommission
     */
    public $lemonWayCommission;

    /**
     * Rules established according to the documentation
     *
     * @see https://apidoc.lemonway.com/
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['senderAccountId', 'maskedLabel', 'bankStatus', 'comment'], 'string'],
            [['debitAmount', 'IbanId', 'originId', 'id', 'date', 'commissionAmount', 'status'], 'integer'],
            [['PSP'], 'kowi\lemon\validators\ObjectValidator', 'targetClass' => 'kowi\lemon\objects\PSP'],
            [['lemonWayCommission'], 'kowi\lemon\validators\ObjectValidator', 'targetClass' => 'kowi\lemon\objects\LemonWayCommission'],
        ]);
    }
}