<?php

namespace kowi\lemon\objects;

use yii\base\Model;

/**
 * Class IndividualAccount
 * @package kowi\lemon\objects
 */
class IndividualAccount extends Model
{
    /**
     * @var string Payment Account ID
     */
    public $id;
    /**
     * @var integer Internal ID given by Lemonway (ID displayed on the BACKOFFICE) ,
     */
    public $internalId;
    /**
     * @var Limits.
     */
    public $limits;
}