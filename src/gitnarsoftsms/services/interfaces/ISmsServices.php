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
     * list: Show list of all sms configration
     * 
     * @access public
     * 
     * @return void
     */
    public function list(): void;

    /**
     * view: Show single sms configration by id
     * 
     * @access public
     * 
     * @return void
     */
    public function view(string $id): void;

    /**
     * create: Render sms config form for new config
     * 
     * @access public
     * 
     * @return void
     */
    public function create(): void;

    /**
     * update: Show sms config form for update current configration
     * 
     * @access public
     * 
     * @param string $id
     * 
     * @return void
     */
    public function update(string $id): void;

    /**
     * render: Render sms config form for both create & update
     * 
     * @access public
     * @param SmsConfig $model
     * @param array $smsConfigHeaders
     * @param array $smsConfigFormData
     * 
     * @return void
     */
    public function render(SmsConfig $model, array $smsConfigHeaders, array $smsConfigFormData): void;

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
     * sendSms: Send sms to user and get sms config info by slug
     * 
     * @access public
     * 
     * @param string $slug
     * @param array $array
     * 
     * @return array
     */
    public function sendSms(string $slug, array $data): array;
}