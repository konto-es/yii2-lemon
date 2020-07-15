<?php

namespace kowi\lemon\resources;

use kowi\lemon\objects\Card;
use yii\base\InvalidConfigException;
use yii\httpclient\Client;
use yii\httpclient\Exception;
use yii\httpclient\Response;

class AccountCardsOutput extends Resource
{
    /** @var Card[] */
    public $cards;

    public function rules()
    {
        return array_merge(parent::rules(), [
            /** @see https://apidoc.lemonway.com/#operation/Accounts_LegalPost */
            [['cards'], 'safe'],
        ]);
    }

    /**
     * @param array $condition
     * @return array|AccountCardsOutput
     * @throws InvalidConfigException
     * @throws Exception
     */
    public static function findAll($condition = [])
    {
        $accountId = $condition['accountId'];
        $response = static::getLemonway()->createRequest()
            ->setFormat(Client::FORMAT_URLENCODED)
            ->setMethod('GET')
            ->setUrl("/v2/moneyins/$accountId/card")
            ->send();

        if (!$response->isOk) {
            $tmp = new static();
            $tmp->addError('Error' . $response->statusCode, $response->data);
            return [$tmp];
        }

        if (isset($response->data['error'])) {
            $tmp = new static();
            $tmp->addError('error', $response->data['error']);
            return [$tmp];
        }

        return static::loadModels($response);
    }

    /**
     * @param Response $response
     * @return AccountCardsOutput
     */
    public static function loadModels(Response $response)
    {
        $result = [];
        foreach ($response->data['cards'] as $record) {
            $tmp = new Card();
            $tmp->scenario = Resource::SCENARIO_LOAD;
            $tmp->setAttributes($record);
            $result[] = $tmp;
        }

        return new static(['cards' => $result]);
    }

    public static function resource()
    {

    }
}