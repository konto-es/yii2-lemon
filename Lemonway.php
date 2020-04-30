<?php

namespace kowi\lemonway;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\httpclient\Client;
use yii\httpclient\Request;

/**
 * Class Module
 * @package ddroche\shasta
 * @see https://sandbox-api.lemonway.fr/mb/kowi/dev/directkitrest/swagger/ui/index#
 *
 * @property string $apiBaseUrl The Lemonway API Base URL
 * @property string $apiKey The Lemonway API Key
 * @property string $httpClient The HTTP Client to access Lemonway service
 */
class Lemonway extends Component
{
    /**
     * @var string The Lemonway API Base URL
     */
    public $apiBaseUrl;
    /**
     * @var string The Lemonway API Key
     */
    public $apiKey;
    /**
     * @var Client The HTTP Client to access Lemonway service
     */
    private $_httpClient;

    /**
     * @return Client
     * @throws InvalidConfigException
     */
    public function getHttpClient()
    {
        if (!is_object($this->_httpClient)) {
            $this->_httpClient = Yii::createObject([
                'class' => 'yii\httpclient\Client',
                'baseUrl' => $this->apiBaseUrl,
            ]);
        }
        return $this->_httpClient;
    }

    /**
     * @return Request
     * @throws InvalidConfigException
     */
    public function createRequest()
    {
        $request = $this->getHttpClient()
            ->createRequest()
            ->setFormat(Client::FORMAT_JSON);
        $request->headers->set('Authorization', $this->apiKey);
        return $request;
    }
    /**
     * @return Request
     * @throws InvalidConfigException
     */
    private function getNewApikey($old){
        /** @var Client $client */

        $client=Yii::createObject([
            'class' => 'yii\httpclient\Client',
            'baseUrl' => 'https://authentication.lemonway.com/v1/token',
        ]);
        $request = $client->createRequest()->setFormat(Client::FORMAT_JSON);
        $request->headers->set('Authorization','Basic '.$old);
        $request->headers->set('accept','application/json;charset=UTF-8');
        $request->addData(['grant_type'=>'client_credentials']);
    }
}
