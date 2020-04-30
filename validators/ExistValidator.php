<?php

namespace kowi\lemonway\validators;

use yii\base\Exception;
use yii\base\Model;
use yii\validators\ExistValidator as BaseExistValidator;

class ExistValidator extends BaseExistValidator
{    
    /**
     * {@inheritdoc}
     */
    public function validateAttribute($model, $attribute)
    {
        if (!empty($this->targetRelation)) {
            $this->checkTargetRelationExistence($model, $attribute);
        } else {
            $this->checkTargetAttributeExistence($model, $attribute);
        }
    }

    /**
     * @param Model $model
     * @param string $attribute
     */
    private function checkTargetRelationExistence($model, $attribute)
    {
        $exists = $model->{'get' . ucfirst($this->targetRelation)}();

        if (!$exists) {
            $this->addError($model, $attribute, $this->message);
        }
    }

    /**
     * @param Model $model
     * @param string $attribute
     * @throws Exception
     */
    private function checkTargetAttributeExistence($model, $attribute)
    {
        throw new Exception('Not Implemented');
    }
}