<?php
namespace gitnarsoftsms\services;

use gitnarsoftsms\models\SmsCommunication;

/**
 * CommunicationService: All sms communication services
 *
 * @category  SMS
 * @package   Service
 * @author    Tirthraj Singh <tirthraj.singh@girnarsoft.com>
 * @copyright 2018 GirnarSoft Pvt. Ltd.
 * @license   2018 GirnarSoft Pvt. Ltd.
 * @link      http://www.girnarsoft.com
 */
class CommunicationService implements interfaces\ICommunicationService
{
    /**
     * getUser: Get sms communication user
     * 
     * @access public
     * 
     * @param string $username
     * @param string $password
     * 
     * @return SmsCommunication
     */
    public function getUser(string $username, string $password): SmsCommunication
    {
        $user = SmsCommunication::findOne(['username' => $username, 'status' => SmsCommunication::STATUS_ENABLE]);

        if(!$user || !\Yii::$app->getSecurity()->validatePassword($password, $user->password)) {
            throw new \yii\web\UnauthorizedHttpException('Unauthorized', 2);
        }

        return $user;
    }
}