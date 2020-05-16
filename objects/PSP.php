<?php

namespace kowi\lemon\objects;

use yii\base\Model;

/**
 * Class PSP
 * @package kowi\lemon\objects
 */
class PSP extends Model
{
    /**
     * @var string Get the error message from PSP
     */
    public $message;

    public function rules()
    {
        return [
            ['message', 'string'],
        ];
    }

}