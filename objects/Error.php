<?php


namespace kowi\lemon\objects;


use yii\base\Model;

class Error extends Model
{
    /**
     * @var integer
     */
    public $code;
    /**
     * @var string
     */
    public $message;
    /**
     * @var string
     */
    public $psp;

    public function rules()
    {
        return [
            [['code', 'message', 'psp'], 'safe'],
        ];
    }
}