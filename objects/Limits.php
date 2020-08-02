<?php

namespace kowi\lemon\objects;

use yii\base\Model;

/**
 * Class Limits
 * @package kowi\lemon\objects
 */
class Limits extends Model
{
    /**
     * @var integer Total money in number allowed for this account
     */
    public $totalMoneyInAllowed;
    /**
     * @var double Total money in amount allowed for this wallet
     */
    public $amountMoneyInAllowed;
}