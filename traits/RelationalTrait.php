<?php

namespace kowi\lemonway\traits;
use ddroche\shasta\resources\ShastaResource;
use yii\base\Exception as BaseException;

trait RelationalTrait {

    protected $_related;

    /**
     * @param string $resource
     * @param string $attribute
     * @return ShastaResource|null
     * @throws BaseException
     */
    public function hasOne($resource, $attribute)
    {
        if (!is_subclass_of($resource, ShastaResource::class)) {
            throw new BaseException("$resource is not subclass of " . ShastaResource::class);
        }
        if (!$this->hasProperty($attribute)) {
            throw new BaseException("$attribute not exit in $resource");
        }
        /** @var ShastaResource $resource */
        if (!isset($this->_related[$attribute])) {
            $this->_related[$attribute] = $resource::findOne($this->$attribute);
        }

        return $this->_related[$attribute];
    }
}