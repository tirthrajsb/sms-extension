<?php
namespace gitnarsoftsms\services;

use yii\helpers\ArrayHelper;
use gitnarsoftsms\models\SmsConfig;
use gitnarsoftsms\models\SmsConfigHeader;
use gitnarsoftsms\models\SmsConfigFormData;
use gitnarsoftsms\models\SmsCommunication;

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
        $model = (new CommunicationService())->getUser($username, $password);
        
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

        return $this->send($params);
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
    private function send(array $data): array
    {
        try {
            $url = $data['SmsConfig']['url'];
            $postData = ArrayHelper::map($data['SmsConfigFormData'], 'data_key', 'data_value');
            
            //Create uri
            if ($data['SmsConfig']['type'] == SmsConfig::TYPE_GET) {
                $url .= '?' . http_build_query($postData);
            }
            
            //Init curl
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, $data['SmsConfig']['timeout']);

            //Set post fields
            if ($data['SmsConfig']['type'] == SmsConfig::TYPE_POST) {
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
            } elseif($data['SmsConfig']['type'] == SmsConfig::TYPE_JSON) {
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postData));
            }

            //Set header's
            if($data['SmsConfigHeader']) {
                $headers = [];
                foreach($data['SmsConfigHeader'] as $header) {
                    $headers[] = $header['header_key'] . ':' . $header['header_value'];
                }

                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            }

            //Execute curl
            $response = curl_exec($curl);
            curl_close($curl);

            return ['response' => $response];
        } catch (Exception $e) {
            return ['exception' => $e];
        }
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