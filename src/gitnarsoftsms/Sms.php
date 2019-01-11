<?php
namespace gitnarsoftsms;

use gitnarsoftsms\services\SmsServices;

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
class Sms
{
    public static function save(array $data): \gitnarsoftsms\models\SmsConfig
    {
        return (new SmsServices())->save($data);
    }

    public static function list(): void
    {
        (new SmsServices())->list();
    }
    
    public static function view(string $id): void
    {
        (new SmsServices())->view($id);
    }

    public static function create(): void
    {
        (new SmsServices())->create();
    }

    public static function update(string $id): void
    {
        (new SmsServices())->update($id);
    }

    public static function check(array $data): array
    {
        return (new SmsServices())->check($data);
    }
}