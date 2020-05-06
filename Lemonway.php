<?php

namespace kowi\lemon;

use DateTime;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\Json;
use yii\httpclient\Client;
use yii\httpclient\Request;

/**
 * Class Module
 * @package ddroche\shasta
 * @see https://sandbox-api.lemonway.fr/mb/app/dev/directkitrest/swagger/ui/index#
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
       $accessToken = $this->getAccessToken();

        $request = $this->getHttpClient()
            ->createRequest()
            ->setFormat(Client::FORMAT_JSON);
        $request->headers->set('Authorization', $accessToken);
        $request->headers->set('PSU-IP-Address', '10.10.10.10');
        return $request;
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

    /**
     * @return string
     * @throws InvalidConfigException
     * @throws \yii\httpclient\Exception
     * @throws \Exception
     */
    private function getAccessToken()
    {
        if (!file_exists($this->getNewApiKeyPath() . 'accessToken.json')) {
            $datos_clientes = file_get_contents($this->getNewApiKeyPath() . '/accessToken.json');
            $token=Json::decode($datos_clientes,true);
            $date1 = new DateTime("now");
            $date2 = new DateTime($token['expire_date']);
            if ($date1 <= $date2) {
                $this->createFile();
            }
            return $token['token_Type'] . ' ' . $token['access_token'];
        } else {
            $this->createFile();
            $token = file_get_contents($this->getNewApiKeyPath() . '/accessToken.json');
            return $token['token_Type'] . ' ' . $token['access_token'];
        }
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
            $date = new DateTime();
            $data['expire_date'] = $date->modify(($data['expires_in'] - 60) . ' second')->format(DateTime::ATOM);
            $json_string = json_encode($data);
            //$php = "<?php return ".print_r($data).";";
            file_put_contents ($this->getNewApiKeyPath() . "/accessToken.json", $json_string);
        }
    }

}
