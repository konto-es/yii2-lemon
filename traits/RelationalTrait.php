<?php

namespace kowi\lemon\traits;

use \kowi\lemon\resources\Resource;
use yii\base\Exception as BaseException;

trait RelationalTrait {

    protected $_related;

    /**
     * @param string $resource
     * @param string $attribute
     * @return Resource|null
     * @throws BaseException
     */
    public function hasOne($resource, $attribute)
    {
        if (!is_subclass_of($resource, Resource::class)) {
            throw new BaseException("$resource is not subclass of " . Resource::class);
        }
        if (!$this->hasProperty($attribute)) {
            throw new BaseException("$attribute not exit in $resource");
        }
        /** @var Resource $resource */
        if (!isset($this->_related[$attribute])) {
            $this->_related[$attribute] = $resource::findOne($this->$attribute);
        }

        return $this->_related[$attribute];
    }
}