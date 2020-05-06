<?php

namespace kowi\lemon\validators;

use yii\validators\Validator;

class ObjectValidator extends Validator
{
    /**
     * @var string
     */
    public $targetClass;
    
    /**
     * {@inheritdoc}
     */
    public function validateAttribute($model, $attribute)
    {
        if (is_array($model->$attribute)) {
            $model->$attribute = new $this->targetClass($model->$attribute);
        }
        if (!$model->$attribute instanceof $this->targetClass) {
            $this->addError($model, $attribute, "The attribute must be an instance of $this->targetClass");
        } elseif (!$model->$attribute->validate()) {
            foreach ($model->$attribute->getErrors() as $field => $error) {
                $this->addError($model, $attribute,"$attribute.$field", $error);
            }
        }
    }
}