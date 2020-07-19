<?php


namespace kowi\lemon\resources;

use kowi\lemon\objects\TransactionOut;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\httpclient\Exception as httpException;
use yii\httpclient\Response;

class MoneyOut extends Resource
{
    /**
     * @var string Payment account ID to be debited.
     */
    public $accountId;
    /**
     * @var integer IBAN ID. If no IBAN is specified, the last verified(validated) IBAN will be used.
     */
    public $ibanId;
    /**
     * @var integer Total amount to debit from the Wallet.
     * The CLIENT will receive on his bank account[totalAmount] minus[commissionAmount].
     * Amounts are given as integer numbers in cents
     */
    public $totalAmount;
    /**
     * @var integer WHITE BRAND fee. Amounts are given as integer numbers in cents.
     */
    public $commissionAmount;
    /**
     * @var string Payment Comment.
     */
    public $comment;
    /**
     * @var boolean This should be set to No (0) for most White Label. If true:
     *    [amountCom] will be ignored and will be replaced with Lemon Way's fee.
     *    The white label will not receive any fee.
     */
    public $autoCommission;
    /**
     * @var TransactionOut
     */
    public $transaction;

    public $id;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['accountId', 'autoCommission'], 'required', 'on' => [static::SCENARIO_CREATE]],
            [['accountId'], 'string', 'max' => 256, 'on' => [static::SCENARIO_CREATE]],
            [['ibanId', 'totalAmount', 'commissionAmount'], 'integer', 'on' => [static::SCENARIO_CREATE]],
            [['comment'], 'string', 'max' => 140, 'on' => [static::SCENARIO_CREATE]],
            [['autoCommission'], 'boolean', 'on' => [static::SCENARIO_CREATE]],
            [['transaction'], 'kowi\lemon\validators\ObjectValidator', 'targetClass' => 'kowi\lemon\objects\TransactionOut', 'on' => [static::SCENARIO_LOAD]],
        ]);
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
            static::SCENARIO_CREATE => '/v2/moneyouts',
        ];
    }
}