# sms-extension
Config sms API

php composer.phar require --prefer-dist wbraganca/yii2-dynamicform "*"

//Controller for admin
<?php

namespace backend\controllers;

use gitnarsoftsms\Sms;
use yii\web\Response;

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
class SmsConfigController extends Controller
{
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
        return $this->render('view', [
            'id' => $id
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
        if (\Yii::$app->request->isPost) {
            $model = Sms::save(\Yii::$app->request->post());
            
            if (!$model->getErrors()) {
                return $this->redirect(['view', 'id' => (string) $model->_id]);
            }
        }
        
        return $this->render('create');
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
        if (\Yii::$app->request->isPost) {
            $model = Sms::save(\Yii::$app->request->post());
            
            if (!$model->getErrors()) {
                return $this->redirect(['view', 'id' => (string) $model->_id]);
            }
        }

        return $this->render('update', [
            'id' => $id
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


//Listing view index.php
\gitnarsoftsms\Sms::list();

//View file view.php
\gitnarsoftsms\Sms::view($id);

//create.php
\gitnarsoftsms\Sms::create();

//update.php
\gitnarsoftsms\Sms::update($id);
