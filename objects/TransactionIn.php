<?php

namespace kowi\lemon\objects;

use yii\base\Model;

/**
 * Class TransactionOut
 * @package kowi\lemon\resources
 */
class TransactionIn extends Model
{
    /**
     * @var string Credited account
     */
    public $receiverAccountId;
    /**
     * @var integer Credited amount Amounts are given as integer numbers in cents.
     */
    public $creditAmount;
    /**
     * @var string
     */
    public $scheduledDate;
    /**
     * @var string
     */
    public $scheduledNumber;
    /**
     * @var integer
     */
    public $method;
    /**
     * @var string
     */
    public $maskedLabel;
    /**
     * @var PSP
     */
    public $PSP;
    /**
     * @var Card
     */
    public $card;
    /**
     * @var string
     */
    public $bankStatus;
    /**
     * @var integer
     */
    public $refundAmount;
    /**
     * @var string Bank reference
     */
    public $bankReference;
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
}