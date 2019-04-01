<?php
namespace gitnarsoftsms\services\interfaces;

use gitnarsoftsms\models\SmsConfig;

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
interface ISmsServices
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
    public function save(array $data): SmsConfig;

    /**
     * check: Check sms config by hitting data to sms service
     * 
     * @access public
     * 
     * @param array $data
     * 
     * @return array
     */
    public function check(array $data): array;
    
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
    public function sendSms(string $username, string $password, array $data): array;

    /**
     * getSmsServices: Return all sms config service providers list
     * 
     * @access public
     * 
     * @return array
     */
    public function getSmsServices(): array;
}