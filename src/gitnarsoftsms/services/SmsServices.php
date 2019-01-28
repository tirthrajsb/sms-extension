<?php
namespace gitnarsoftsms\services;

use gitnarsoftsms\models\SmsConfig;
use gitnarsoftsms\models\SmsConfigHeader;
use gitnarsoftsms\models\SmsConfigFormData;
use yii\helpers\ArrayHelper;

/**
 * SmsServices: Set config for send sms
 *
 * @category  PHP
 * @package   SMS
 * @author    Tirthraj Singh <tirthraj.singh@girnarsoft.com>
 * @copyright 2018 GirnarSoft Pvt. Ltd.
 * @license   2018 GirnarSoft Pvt. Ltd.
 * @link      http://www.girnarsoft.com
 */
class SmsServices implements interfaces\ISmsServices
{
    /**
     * save: Save sms config data & headers
     * 
     * @access public
     * 
     * @param array $data
     * 
     * @return SmsConfig
     */
    public function save(array $data): SmsConfig
    {
        if(!empty($data['SmsConfig']['_id'])) {
            $model = SmsConfig::findOne($data['SmsConfig']['_id']);
        } else {
            $model = new SmsConfig();
        }

        $model->load($data);
        
        if($model->save()) {
            $this->saveSmsConfigFormData($model, $data['SmsConfigFormData']);
            $this->saveSmsConfigHeader($model, $data['SmsConfigHeader']);
        }
        
        return $model;
    }

    /**
     * saveSmsConfigFormData: Save sms config form data values for get/post
     * 
     * @access private
     * 
     * @param SmsConfig $smsConfig
     * @param array $data
     * 
     * @return void
     */
    private function saveSmsConfigFormData(SmsConfig $smsConfig, array $data): void
    {
        SmsConfigFormData::deleteAll(['sms_config_id' => (string) $smsConfig->_id]);

        foreach($data as $row) {
            if(!empty($row['data_key'])) {
                $model = new SmsConfigFormData();
                $model->load(['SmsConfigFormData' => $row]);
                $model->sms_config_id = (string) $smsConfig->_id;
                $model->save();
            }
        }
    }

    /**
     * saveSmsConfigHeader: Save sms config headers for get/post
     * 
     * @access private
     * 
     * @param SmsConfig $smsConfig
     * @param array $data
     * 
     * @return void
     */
    private function saveSmsConfigHeader(SmsConfig $smsConfig, array $data): void
    {
        SmsConfigHeader::deleteAll(['sms_config_id' => (string) $smsConfig->_id]);

        foreach($data as $row) {
            if(!empty($row['header_key'])) {
                $model = new SmsConfigHeader();
                $model->load(['SmsConfigHeader' => $row]);
                $model->sms_config_id = (string) $smsConfig->_id;
                $model->save();
            }
        }
    }

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
     * sendSms: Send sms to user and get sms config info by slug
     * 
     * @access public
     * 
     * @param string $slug
     * @param array $array
     * 
     * @return array
     */
    public function sendSms(string $slug, array $data): array
    {
        $model = SmsConfig::findOne(['slug' => $slug]);

        if (!$model) {
            throw new \yii\web\NotFoundHttpException("$slug: Configration not availabel");
        }

        $params['SmsConfig'] = $model->attributes;
        $params['SmsConfigFormData'] = [];
        $params['SmsConfigHeader'] = [];

        if($model->smsConfigFormData) {
            foreach($model->smsConfigFormData as $formData) {
                $params['SmsConfigFormData'][] = [
                    'data_key' => $formData->data_key,
                    'data_value' => \Yii::t('app', $formData->data_value, $data),
                ];
            }
        }

        if($model->smsConfigHeaders) {
            foreach($model->smsConfigHeaders as $headers) {
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
}