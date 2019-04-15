<?php

namespace gitnarsoftsms\controllers;

use yii\base\Module;
use yii\web\Response;
use gitnarsoftsms\models\SmsConfig;
use gitnarsoftsms\models\SmsConfigHeader;
use gitnarsoftsms\models\SmsConfigFormData;
use gitnarsoftsms\services\SmsService;

/**
 * SmsConfigController for all types of sms service config
 *
 * @category  PHP
 * @package   Backend
 * @author    Tirthraj Singh <tirthraj.singh@girnarsoft.com>
 * @copyright 2018 Girnarsoft
 * @license   https://girnarsoft.com/licence.txt BSD Licence
 * @link      carbay.com
 *
 */
class SmsConfigController extends \yii\web\Controller
{
    private $smsService;

    public function __construct($id, Module $module, SmsService $smsService, $config = [])
    {
        $this->smsService = $smsService;
        parent::__construct($id, $module, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function beforeAction($action)
    {
        if (\Yii::$app->getUser()->isGuest) {
            return $this->redirect(\Yii::$app->user->loginUrl)->send();
        }
        
        \Yii::$app->response->format = Response::FORMAT_HTML;
        return parent::beforeAction($action);
    }

    /**
     * actionIndex: Show all sms config list
     *
     * @access public
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * actionView: View sms config data
     *
     * @access public
     *
     * @param string $id
     *
     * @return mixed
     */
    public function actionView(string $id)
    {
        $model = SmsConfig::findOne($id);

        if (!$model) {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('view', [
            'model' => $model
        ]);
    }

    /**
     * actionCreate: Create new form
     *
     * @access public
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SmsConfig();
        $model->load(\Yii::$app->request->post());

        if (\Yii::$app->request->isPost && $model->validate()) {
            if($model->save()) {
                $this->saveSmsConfigFormData($model, \Yii::$app->request->post('SmsConfigFormData'));
                $this->saveSmsConfigHeader($model, \Yii::$app->request->post('SmsConfigHeader'));
                return $this->redirect(['view', 'id' => (string) $model->_id]);
            }
        }
        
        $smsConfigHeaders = [new SmsConfigHeader()];
        $smsConfigFormData = [new SmsConfigFormData()];

        return $this->render('create', [
            'model' => $model,
            'smsConfigHeaders' => $smsConfigHeaders,
            'smsConfigFormData' => $smsConfigFormData,
        ]);
    }
    
    /**
     * actionUpdate: Update sms config
     *
     * @access public
     *
     * @param string $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = SmsConfig::findOne($id);

        if (!$model) {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }

        $model->load(\Yii::$app->request->post());
        
        if (\Yii::$app->request->isPost && $model->validate()) {
            if($model->save()) {
                $this->saveSmsConfigFormData($model, \Yii::$app->request->post('SmsConfigFormData'));
                $this->saveSmsConfigHeader($model, \Yii::$app->request->post('SmsConfigHeader'));
                return $this->redirect(['view', 'id' => (string) $model->_id]);
            }
        }

        $smsConfigHeaders = $model->smsConfigHeaders ? $model->smsConfigHeaders : [(new SmsConfigHeader())];
        $smsConfigFormData = $model->smsConfigFormData ? $model->smsConfigFormData : [(new SmsConfigFormData())];

        return $this->render('update', [
            'model' => $model,
            'smsConfigHeaders' => $smsConfigHeaders,
            'smsConfigFormData' => $smsConfigFormData,
        ]);
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
     * actionCheck: Check sms api
     *
     * @access public
     *
     * @return mixed
     */
    public function actionCheck()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        if (\Yii::$app->request->isPost) {
            return $this->smsService->check(\Yii::$app->request->post());
        }
        
        return [];
    }
}
