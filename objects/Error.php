<?php


namespace kowi\lemon\objects;


use yii\base\Model;

class Error extends Model
{
    /**
     * @var integer $code
     */
    public $code;
    /**
     * @var string $message
     */
    public $message;

    public function rules()
    {
        return array_merge(parent::rules(),[
            [['code','message'],'safe'],
        ]);
    }
}