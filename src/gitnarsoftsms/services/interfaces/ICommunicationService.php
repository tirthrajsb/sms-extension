<?php
namespace gitnarsoftsms\services\interfaces;

use gitnarsoftsms\models\communication\SmsCommunication;

/**
 * CommunicationService: All sms communication services
 *
 * @category  SMS
 * @package   Interface
 * @author    Tirthraj Singh <tirthraj.singh@girnarsoft.com>
 * @copyright 2018 GirnarSoft Pvt. Ltd.
 * @license   2018 GirnarSoft Pvt. Ltd.
 * @link      http://www.girnarsoft.com
 */
interface ICommunicationService
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
    public function getUser(string $username, string $password): SmsCommunication;
}