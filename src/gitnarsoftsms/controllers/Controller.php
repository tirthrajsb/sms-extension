<?php

namespace gitnarsoftsms\controllers;

//use yii\web\Response;

/**
 * Controller for all types of sms service config
 *
 * @category  PHP
 * @package   Backend
 * @author    Tirthraj Singh <tirthraj.singh@girnarsoft.com>
 * @copyright 2018 Girnarsoft
 * @license   https://girnarsoft.com/licence.txt BSD Licence
 * @link      carbay.com
 *
 */
class Controller extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        if (\Yii::$app->getUser()->isGuest) {
            return $this->redirect(\Yii::$app->user->loginUrl)->send();
        }
        
        //\Yii::$app->response->format = Response::FORMAT_HTML;
        return parent::beforeAction($action);
    }

}
