<?php


namespace kowi\lemon\resources;

use http\Client;
use http\Exception;
use kowi\lemon\Lemonway;
use kowi\lemon\objects\Error;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\httpclient\Response;

abstract class LemonwayResource extends Model
{
    const SCENARIO_LOAD = 'load';
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public $error;

    public abstract static function resource();

    public function rules()
    {
        return array_merge(parent::rules(),[
            [['error'],'safe', 'on' => [static::SCENARIO_LOAD]],
        ]);
    }

    /**
     * @return Lemonway
     * @throws InvalidConfigException
     * @throws \yii\base\InvalidConfigException
     */
    public static function getLemonway()
    {
        /** @var Lemonway $lemonway */
        $lemonway = Yii::$app->get('lemonway');
        return $lemonway;
    }

    /**
     * @param bool $runValidation
     * @param null $attributeNames
     * @return bool
     * @throws InvalidConfigException
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->id == null) {
            return $this->insert($runValidation, $attributeNames);
        }

        return $this->update($runValidation, $attributeNames);
    }

    /**
     * Create resource into the Shasta RESTful API using ShastaResource object
     *
     * Usage example:
     *
     * ```php
     * $customer = new Customer;
     * $customer->first_name = $first_name;
     * $customer->last_name = $last_name;
     * $this->create($customer);
     * ```
     *
     * @param bool $runValidation whether to perform validation (calling [[\yii\base\Model::validate()|validate()]])
     * before saving the record. Defaults to `true`. If the validation fails, the record
     * will not be saved to the database and this method will return `false`.
     * @param array $attributes list of attributes that need to be saved. Defaults to `null`.
     * @return bool whether the attributes are valid and the record is inserted successfully.
     * @throws InvalidConfigException
     */
    public function insert($runValidation = true, $attributes = null)
    {
        $this->scenario = static::SCENARIO_CREATE;

        if ($runValidation && !$this->validate($attributes)) {
            Yii::info('Model not inserted due to validation error.', __METHOD__);
            Yii::info($this->getErrors(), __METHOD__);
            return false;
        }


        $attributes = $this->safeAttributes();
        $toArray = [];
        foreach ($attributes as $attribute) {
            if (isset($this->$attribute)) {
                $toArray[] = $attribute;
            }
        }
        $response = static::getLemonway()->createRequest()
            ->setMethod('POST')
            ->setUrl(static::resource()[$this->scenario])
            ->setData($this->toArray($toArray))
            ->send();

        return $this->loadAttributes($response);
    }

    /**
     * @param bool $runValidation
     * @param null $attributes
     * @return bool
     * @throws InvalidConfigException
     */
    public function update($runValidation = true, $attributes = null)
    {

        if (!$this->id) {
            $this->addError('Id is require for update operation');
            return false;
        }
        $this->scenario = LemonwayResource::SCENARIO_DEFAULT;

        if ($runValidation && !$this->validate($attributes)) {
            Yii::info('Model not updated due to validation error.', __METHOD__);
            Yii::info($this->getErrors(), __METHOD__);
            return false;
        }

        $attributes = $this->safeAttributes();
        $toArray = [];
        foreach ($attributes as $attribute) {
            if (isset($this->$attribute)) {
                $toArray[] = $attribute;
            }
        }
        $response = static::getLemonway()->createRequest()
            ->setMethod('PUT')
            ->setUrl(static::resource()[$this->scenario] . "/$this->id")
            ->setData($this->toArray($toArray))
            ->send();

        return $this->loadAttributes($response);
    }

    /**
     * @param mixed $condition primary key value or a set of column values
     * @return static|null ShastaResource instance matching the condition, or `null` if nothing matches.
     * @throws Exception
     * @throws InvalidConfigException
     */
    public static function findOne($condition = null)
    {
        if ($condition === null) {
            $objects = static::findAll();
            return count($objects) ? $objects[0] : null;
        }

        if (is_string($condition)) {
            /** @var LemonwayResource $object */
            $object = new static(['id' => $condition]);
            return $object->read() ? $object : null;
        }

        if (is_array($condition)) {
            $object = new static($condition);

            return $object->read() ? $object : null;
        }
        return null;
    }

    /**
     * @return bool
     * @throws Exception
     * @throws InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function read()
    {

        if (!$this->id) {
            $this->addError('Id is require for read operation');
            return false;
        }
        $response = static::getLemonway()->createRequest()
            ->setMethod('GET')
            ->setUrl(static::resource()['load'] . "/$this->id")
            ->send();
        //var_dump($response->data);die;
        return $this->loadAttributes($response);

    }

    /**
     * @param array $condition
     * @return array
     * @throws InvalidConfigException
     */
    public static function findAll($condition = [])
    {
        $response = static::getLemonway()->createRequest()
            ->setFormat(Client::FORMAT_URLENCODED)
            ->setMethod('GET')
            ->setUrl(static::resource())
            ->setData($condition)
            ->send();

        if (!$response->isOk) {
            $tmp = new static();
            $tmp->addError('Error' . $response->statusCode, $response->data);
            return [$tmp];
        }

        $result = [];
        foreach ($response->data['data'] as $record) {
            $tmp = new static();
            $tmp->scenario = LemonwayResource::SCENARIO_LOAD;
            $tmp->setAttributes($record);
            $result[] = $tmp;
        }

        return $result;
    }

    /**
     * @param Response $response
     * @return bool
     */
    public function loadAttributes(Response $response)
    {
        if (!$response->isOk) {
            $this->addError('Error' . $response->statusCode, $response->data);
            Yii::info($this->getErrors(), __METHOD__);
            return false;
        } elseif (isset($response->data['error'])) {
            $error = new Error();
            $error->setAttributes($response->data['error']);
            $this->addError('error' , $error);
            Yii::info($this->getErrors(), __METHOD__);
          // var_dump($response->data['error']);
          // var_dump($error);
            return true;
        }
        $this->scenario = LemonwayResource::SCENARIO_LOAD;
        $this->setAttributes($response->data);

        return true;
    }

}