<?php

namespace kowi\lemon;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\Json;
use yii\httpclient\Client;
use yii\httpclient\Request;
use yii\web\HttpException;

/**
 * Class Lemonway
 * @package kowi\lemon
 * @see https://sandbox-api.lemonway.fr/mb/app/dev/directkitrest/swagger/ui/index#
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
     * @var String Client credential grant use to request access token
     */
    public $apiAuthUrl;
    /**
     * @var String
     */
    public $newApiKeyPath;
    /**
     * @var Client This service strictly follow the chapter 4.4.2 “Access Token request” of the RFC 6749
     * "the Oauth2 2.0 Authorization Framework". This Api is consume by the client api, a restrict control on IP is applied.
     */
    private $_httpClient;

    /**
     * @return String
     */
    public function getNewApiKeyPath()
    {
        return Yii::getAlias($this->newApiKeyPath);
    }

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
     * @throws \yii\httpclient\Exception
     */
    public function createRequest()
    {
        $request = $this->getHttpClient()->createRequest()->setFormat(Client::FORMAT_JSON);
        $request->headers->set('Authorization', $this->getAccessToken());
        $request->headers->set('PSU-IP-Address', '10.10.10.10');
        return $request;
    }

    /**
     * @return string
     * @throws InvalidConfigException
     * @throws \yii\httpclient\Exception
     * @throws \Exception
     */
    private function getAccessToken()
    {
        if (file_exists($this->getNewApiKeyPath())) {
            $data = file_get_contents($this->getNewApiKeyPath());
            $data = Json::decode($data,true);
            if ($data['expires_at'] <= time()) {
                $data = $this->createFile();
            }

        } else {
            $data = $this->createFile();
        }

        return $data['token_Type'] . ' ' . $data['access_token'];
    }

    /**
     * @throws InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    private function createFile()
    {
        $response = $this->getNewApikey();
        if ($response->isOk) {
            $data = $response->data;
            $data['expires_at'] = $data['expires_in'] + time();
            $json_string = Json::encode($data);
            file_put_contents($this->getNewApiKeyPath(), $json_string);
            return $data;
        } else {
            throw new HttpException('Error on get new api key');
        }
    }

    /**
     * @return \yii\httpclient\Response
     * @throws InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    private function getNewApikey()
    {
        /** @var Client $client */
        $client = Yii::createObject([
            'class' => 'yii\httpclient\Client',
            'baseUrl' => $this->apiAuthUrl,
        ]);
        $request = $client->createRequest()->setFormat(Client::FORMAT_URLENCODED);
        $request->headers->set('Authorization', 'Basic ' . $this->apiKey);
        $request->headers->set('accept', 'application/json;charset=UTF-8');
        $request->addData(['grant_type' => 'client_credentials']);
        $response = $request->setMethod('POST')->send();
        return $response;
    }
}
