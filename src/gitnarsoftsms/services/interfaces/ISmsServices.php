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
    public function create(): void;
    public function render(SmsConfig $model, array $smsConfigHeaders, array $smsConfigFormData): void;
}