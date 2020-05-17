<?php


namespace kowi\lemon\resources;

use kowi\lemon\enums\IbanStatus;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\httpclient\Exception as httpException;
use yii\httpclient\Response;

class Iban extends Resource
{
    /**
     * @var string Payment account ID.
     */
    public $accountId;
    /**
     * @var string IBAN owner: first name and last name, or enterprise name.
     */
    public $holder;
    /**
     * @var string BIC/SWIFT code. Not mandatory.
     * The correct format is : [6 letters] + [2 numbers or letters] + [0 or 3 numbers or letters].
     */
    public $bic;
    /**
     * @var string IBAN
     */
    public $iban;
    /**
     * @var string First line of domiciliation. Generally, the name of the bank branch.
     * Can be left empty if the IBAN is from France or Monaco (starts with FR or MC).
     */
    public $domiciliation1;
    /**
     * @var string Second line of domiciliation. Generally, the street of the bank branch.
     * Can be left empty if the IBAN is from France or Monaco (starts with FR or MC).
     */
    public $domiciliation2;
    /**
     * @var string Reason for new IBAN if another IBAN is already linked to the wallet.
     */
    public $comment;
    /**
     * @var integer IBAN ID
     */
    public $ibanId;
    /**
     * @var integer IBAN Status
     */
    public $status;
    /**
     * @var integer Indicates it it's a merchant iban or a virtual client iban. 1: merchant iban 2: iban virtual client.
     */
    public $type;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['accountId', 'holder', 'iban'], 'required', 'on' => [static::SCENARIO_CREATE]],
            [['accountId'], 'string', 'max' => 256, 'on' => [static::SCENARIO_CREATE]],
            [['holder'], 'string', 'min' => 1, 'max' => 100, 'on' => [static::SCENARIO_CREATE]],
            [['bic'], 'string', 'min' => 8, 'max' => 11, 'on' => [static::SCENARIO_CREATE]],
            [['iban'], 'string', 'min' => 15, 'max' => 34, 'on' => [static::SCENARIO_CREATE]],
            [['domiciliation1', 'domiciliation1'], 'string', 'min' => 1, 'max' => 256, 'on' => [static::SCENARIO_CREATE]],
            [['comment'], 'string', 'min' => 1, 'max' => 512, 'on' => [static::SCENARIO_CREATE]],
            [['id', 'ibanId', 'status', 'iban', 'swift', 'holder', 'type'], 'safe', 'on' => [static::SCENARIO_LOAD]],
        ]);
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['id', 'swift']);
    }

    public function getId()
    {
        return $this->ibanId;
    }

    public function setId($id)
    {
        $this->ibanId = $id;
    }

    public function getSwift()
    {
        return $this->bic;
    }

    public function setSwift($swift)
    {
        $this->bic = $swift;
    }

    public function getStatusLabel()
    {
        return IbanStatus::getLabel($this->status);
    }

    /**
     * @param $accountId
     * @return Resource[]
     * @throws InvalidConfigException
     * @throws httpException
     */
    public static function findAllIbans($accountId)
    {
        return parent::findAll(['accountid' => $accountId]);
    }

    /**
     * @param Response $response
     * @return array
     * @throws Exception
     */
    public static function loadModels(Response $response)
    {
        $result = [];
        foreach ($response->data['ibans'] as $record) {
            $tmp = new static();
            $tmp->scenario = Resource::SCENARIO_LOAD;
            $tmp->setAttributes($record);
            $result[] = $tmp;
        }

        return $result;
    }

    public static function resource()
    {
        return [
            static::SCENARIO_LOAD => '/v2/moneyouts/{accountid}/iban',
            static::SCENARIO_CREATE => '/v2/moneyouts/iban',
        ];
    }
}