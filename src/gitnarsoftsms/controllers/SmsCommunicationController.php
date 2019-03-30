<?php

namespace gitnarsoftsms\controllers;

use gitnarsoftsms\Sms;
use yii\web\Response;
use gitnarsoftsms\models\SmsCommunication;
use yii\helpers\ArrayHelper;

/**
 * SmsCommunicationController for all types of sms service communication
 *
 * @category  PHP
 * @package   Backend
 * @author    Tirthraj Singh <tirthraj.singh@girnarsoft.com>
 * @copyright 2018 Girnarsoft
 * @license   https://girnarsoft.com/licence.txt BSD Licence
 * @link      carbay.com
 *
 */
class SmsCommunicationController extends \yii\web\Controller
{
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
     * actionIndex: Show all sms communication list
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
     * actionView: View sms communication data
     *
     * @access public
     *
     * @param string $id
     *
     * @return mixed
     */
    public function actionView(string $id)
    {
        $model = SmsCommunication::findOne($id);

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
        $model = new SmsCommunication();
        $model->load(\Yii::$app->request->post());

        if (\Yii::$app->request->isPost && $model->validate()) {
            $model->save();
            
            if (!$model->getErrors()) {
                return $this->redirect(['view', 'id' => (string) $model->_id]);
            }
        }
        
        return $this->render('create', [
            'model' => $model,
            'smsServices' => ArrayHelper::map(Sms::getSmsServices(), '_id', 'name')
        ]);
    }
    
    /**
     * actionUpdate: Update sms communication
     *
     * @access public
     *
     * @param string $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = SmsCommunication::findOne($id);

        if (!$model) {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }

        $model->load(\Yii::$app->request->post());
        
        if (\Yii::$app->request->isPost && $model->validate()) {
            $model->save();
            
            if (!$model->getErrors()) {
                return $this->redirect(['view', 'id' => (string) $model->_id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'smsServices' => ArrayHelper::map(Sms::getSmsServices(), '_id', 'name')
        ]);
    }
}
