<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2019 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace gitnarsoftsms;

use yii\base\BootstrapInterface;

/**
 * This is the main module class for the SMS module.
 *
 * To use SMS, include it as a module in the application configuration like the following:
 *
 * ~~~
 * return [
 *     'bootstrap' => ['sms-config'],
 *     'modules' => [
 *         'sms-config' => ['class' => 'gitnarsoftsms\Module'],
 *     ],
 * ]
 * ~~~
 *
 * With the above configuration, you will be able to access SmsModule in your browser using
 * the URL `http://localhost/path/to/index.php?r=sms-config`
 *
 * If your application enables [[\yii\web\UrlManager::enablePrettyUrl|pretty URLs]],
 * you can then access Gii via URL: `http://localhost/path/to/index.php/sms-config`
 *
 * @author Tirthraj Singh <tirthraj.singh@girnarsoft.com>
 * @since 2.0
 */
class Module extends \yii\base\Module implements BootstrapInterface
{
    /**
     * {@inheritdoc}
     */
    public function bootstrap($app)
    {
        $app->getUrlManager()->addRules([
            ['class' => 'yii\web\UrlRule', 'pattern' => 'sms-config', 'route' => $this->id . '/sms-config/index'],
            ['class' => 'yii\web\UrlRule', 'pattern' => 'sms-config/index', 'route' => $this->id . '/sms-config/index'],
            ['class' => 'yii\web\UrlRule', 'pattern' => 'sms-config/view/<id>', 'route' => $this->id . '/sms-config/view'],
            ['class' => 'yii\web\UrlRule', 'pattern' => 'sms-config/create', 'route' => $this->id . '/sms-config/create'],
            ['class' => 'yii\web\UrlRule', 'pattern' => 'sms-config/update/<id>', 'route' => $this->id . '/sms-config/update'],
            ['class' => 'yii\web\UrlRule', 'pattern' => 'sms-config/check', 'route' => $this->id . '/sms-config/check'],
            ['class' => 'yii\web\UrlRule', 'pattern' => 'sms-communication', 'route' => $this->id . '/sms-communication/index'],
            ['class' => 'yii\web\UrlRule', 'pattern' => 'sms-communication/index', 'route' => $this->id . '/sms-communication/index'],
            ['class' => 'yii\web\UrlRule', 'pattern' => 'sms-communication/view/<id>', 'route' => $this->id . '/sms-communication/view'],
            ['class' => 'yii\web\UrlRule', 'pattern' => 'sms-communication/create', 'route' => $this->id . '/sms-communication/create'],
            ['class' => 'yii\web\UrlRule', 'pattern' => 'sms-communication/update/<id>', 'route' => $this->id . '/sms-communication/update']
        ], false);
    }
}