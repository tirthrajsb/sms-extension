<?php
namespace gitnarsoftsms\services;

use yii\helpers\ArrayHelper;
use yii\httpclient\Client;
use yii\web\UnauthorizedHttpException;
use yii\httpclient\Exception;
use gitnarsoftsms\models\config\SmsConfig;
use gitnarsoftsms\models\config\SmsConfigHeader;
use gitnarsoftsms\models\config\SmsConfigFormData;
use gitnarsoftsms\models\communication\SmsCommunication;
use gitnarsoftsms\models\log\SmsLog;

/**
 * SmsService: Set config for send sms
 *
 * @category  PHP
 * @package   SMS
 * @author    Tirthraj Singh <tirthraj.singh@girnarsoft.com>
 * @copyright 2018 GirnarSoft Pvt. Ltd.
 * @license   2018 GirnarSoft Pvt. Ltd.
 * @link      http://www.girnarsoft.com
 */
class SmsService implements interfaces\ISmsService
{
    /**
     * check: Check sms config by hitting data to sms service
     * 
     * @access public
     * 
     * @param array $data
     * 
     * @return array
     */
    public function check(array $data): array
    {
        $data['SmsConfig'] = $data['SmsConfig'] ?? [];
        $data['SmsConfigFormData'] = $data['SmsConfigFormData'] ?? [];
        $data['SmsConfigHeader'] = $data['SmsConfigHeader'] ?? [];

        return $this->send($data);
    }

    /**
     * sendSms: Send sms to user and get sms config info by username
     * 
     * @access public
     * 
     * @param string $username
     * @param string $password
     * @param array $array
     * 
     * @return array
     */
    public function sendSms(string $username, string $password, array $data): array
    {
        //Create log model object
        $log = new SmsLog();

        //Set User
        $log->username = $username;
        $log->ip = $this->getClientIp();
        $log->request = "Not set";

        try {
            $model = (new CommunicationService())->getUser($username, $password);

            if(!empty($model->ip)) {
                $ips = explode(',', trim($model->ip));

                if(!in_array($this->getClientIp(), $ips)) {
                    throw new UnauthorizedHttpException('Unauthorized IP', SmsConfig::CODE_UNAUTHORIZED);
                }
            }
            
            $params['SmsConfig'] = $model->smsConfig->attributes;
            $params['SmsConfigFormData'] = [];
            $params['SmsConfigHeader'] = [];

            if($model->smsConfig->smsConfigFormData) {
                foreach($model->smsConfig->smsConfigFormData as $formData) {
                    $params['SmsConfigFormData'][] = [
                        'data_key' => $formData->data_key,
                        'data_value' => \Yii::t('app', $formData->data_value, $data),
                    ];
                }
            }

            if($model->smsConfig->smsConfigHeaders) {
                foreach($model->smsConfig->smsConfigHeaders as $headers) {
                    $params['SmsConfigHeader'][] = $headers->attributes;
                }
            }

            //Set request
            $log->request = $params;

            //Send SMS
            $response = $this->send($params);

            //Set response
            $log->response = $response;
            $log->save();

            return [
                "message" => \Yii::t('app', 'Success'),
                "code" => SmsConfig::CODE_SUCCESS,
                "response" => $response
            ];
        } catch (UnauthorizedHttpException $exception) {
            return [
                "message" => $exception->getMessage(),
                "code" => SmsConfig::CODE_UNAUTHORIZED
            ];
        } catch (Exception $exception) {
            //Set response
            $log->response = $exception->getMessage();
            $log->save();

            return [
                "message" => $exception->getMessage(),
                "code" => SmsConfig::CODE_EXCEPTION
            ];
        } catch(\Exception $exception) {
            //Set response
            $log->response = $exception->getMessage();
            $log->save();

            return [
                'message' => $exception->getMessage(),
                'code' => $exception->getCode()
            ];
        }
    }

    /**
     * send: Send sms to user
     * 
     * @access private
     * 
     * @param array $data
     * 
     * @return array
     */
    private function send(array $data)
    {
        //Set request data to send
        $request = ArrayHelper::map($data['SmsConfigFormData'], 'data_key', 'data_value');
        $method = $data['SmsConfig']['type'];
        
        //Create uri
        $url = $data['SmsConfig']['url'];
        
        //Set query string if method is GET
        if ($method == SmsConfig::TYPE_GET) {
            $url .= '?' . http_build_query($request);
        }

        //Set Request Format
        $requestConfig = [];

        if ($method == SmsConfig::TYPE_XML) {
            $requestConfig = [
                'format' => Client::FORMAT_XML
            ];
        }

        //Set client config's
        $config = [
            'transport' => 'yii\httpclient\CurlTransport', // only cURL supports the options we need
            'requestConfig' => $requestConfig,
            'responseConfig' => [
                'format' => $data['SmsConfig']['response_format']
            ]
        ];

        $client = new Client($config);
        $client = $client->createRequest();

        //Set post method
        if (in_array($method, [SmsConfig::TYPE_POST, SmsConfig::TYPE_JSON, SmsConfig::TYPE_XML])) {
            $client = $client->setMethod('POST');
        }
        
        //Create request
        $client = $client->setUrl($url);

        if (in_array($method, [SmsConfig::TYPE_POST, SmsConfig::TYPE_JSON, SmsConfig::TYPE_XML])) {
            $client = $client->setData($request);
        }

        //Set options
        $client = $client->setOptions([
                    CURLOPT_CONNECTTIMEOUT => ($data['SmsConfig']['timeout'] ? $data['SmsConfig']['timeout'] : 5), // connection timeout
                    CURLOPT_TIMEOUT => 10, // data receiving timeout
                ]);
        
        //Set header informations
        if($data['SmsConfigHeader']) {
            $headers = [];

            foreach($data['SmsConfigHeader'] as $header) {
                $headers[$header['header_key']] = $header['header_value'];
            }

            $client = $client->addHeaders($headers);
        }

        $response = $client->send();
        return ($response->data ? $response->data : []);
    }

    /**
     * getClientIp: Get client IP
     *
     * @return string
     */
    private static function getClientIp(): string
    {
        if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $clientIpAddress = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } elseif (!empty($_SERVER["REMOTE_ADDR"])) {
            $clientIpAddress = $_SERVER["REMOTE_ADDR"];
        } elseif (!empty($_SERVER["HTTP_CLIENT_IP"])) {
            $clientIpAddress = $_SERVER["HTTP_CLIENT_IP"];
        } else {
            $clientIpAddress = $_SERVER['REMOTE_ADDR'];
        }

        $clientIpArray = explode(',', $clientIpAddress);
        return end($clientIpArray);
    }

    /**
     * getSmsService: Return all sms config service providers list
     * 
     * @access public
     * 
     * @return array
     */
    public function getSmsService(): array
    {
        $services = [];
        $resuts = SmsConfig::find()->all();

        foreach($resuts as $resut) {
            $services[] = [
                '_id' => (string) $resut->_id,
                'name' => (string) $resut->name
            ];
        }

        return $services;
    }
}