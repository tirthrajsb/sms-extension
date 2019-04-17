<?php

namespace gitnarsoftsms\controllers;

use yii\base\Module;
use gitnarsoftsms\models\log\SmsLogSearch;

/**
 * SmsLogController for all types of sms service config
 *
 * @category  PHP
 * @package   Backend
 * @author    Tirthraj Singh <tirthraj.singh@girnarsoft.com>
 * @copyright 2018 Girnarsoft
 * @license   https://girnarsoft.com/licence.txt BSD Licence
 * @link      carbay.com
 *
 */
class SmsLogController extends Controller
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
        $model = new SmsLogSearch();
        $dataProvider = $model->search(\Yii::$app->request->get());
        
        return $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
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
        $model = SmsLogSearch::findOne($id);

        if (!$model) {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('view', [
            'model' => $model
        ]);
    }
}
