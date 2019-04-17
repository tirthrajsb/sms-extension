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
            ['class' => 'yii\web\UrlRule', 'pattern' => '<controller:(sms-log|sms-config|sms-communication)>', 'route' => $this->id . '/<controller>/index'],
            ['class' => 'yii\web\UrlRule', 'pattern' => '<controller:(sms-log|sms-config|sms-communication)>/<action>', 'route' => $this->id . '/<controller>/<action>'],
            ['class' => 'yii\web\UrlRule', 'pattern' => '<controller:(sms-log|sms-config|sms-communication)>/<action>/<id>', 'route' => $this->id . '/<controller>/<action>/<id>']
        ], false);
    }
}