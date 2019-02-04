<?php

namespace gitnarsoftsms\controllers;

use gitnarsoftsms\Sms;
use yii\web\Response;
use gitnarsoftsms\models\SmsConfig;
use gitnarsoftsms\models\SmsConfigHeader;
use gitnarsoftsms\models\SmsConfigFormData;

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
    //public $layout = 'main';

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
            $model = Sms::save(\Yii::$app->request->post());
            
            if (!$model->getErrors()) {
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
            $model = Sms::save(\Yii::$app->request->post());
            
            if (!$model->getErrors()) {
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
            return Sms::check(\Yii::$app->request->post());
        }
        
        return [];
    }
}
