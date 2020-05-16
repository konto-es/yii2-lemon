<?php

namespace kowi\lemon\objects;

use yii\base\Model;

/**
 * Class LemonWayCommission
 * @package kowi\lemon\objects
 */
class LemonWayCommission extends Model
{
    /**
     * @var string
     */
    public $idp2p;
    /**
     * @var integer Amounts are given as integer numbers in cents Amounts are given as integer numbers in cents.
     */
    public $amount;

    public function rules()
    {
        return [
            ['idp2p', 'string'],
            ['amount', 'integer'],
        ];
    }

}