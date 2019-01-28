# sms-extension
Config sms API

php composer.phar require --prefer-dist wbraganca/yii2-dynamicform "*"

This is the main module class for the SMS module.

#To use SMS Module, include it as a module in the application configuration like the following:

-------------
return [
    'bootstrap' => ['sms-config'],
    'modules' => [
        'sms-config' => ['class' => 'gitnarsoftsms\Module'],
    ],
]
-------------

#Use this code to send sms

\gitnarsoftsms\Sms::sendSms(string $slug, array $data)

#Set config tip's
Use {your key} in form data of header for dynamic value

Examle
----------------------
Key    |   Value      |
----------------------
mobile |   {mobile}   |
----------------------
msg    |   {message}  |
----------------------
With the above configuration, you will be able to access SmsModule in your browser using
the URL `http://www.example.com/index.php?r=sms-config`

If your application enables [[\yii\web\UrlManager::enablePrettyUrl|pretty URLs]],
you can then access Gii via URL: `http://www.example.com/index.php/sms-config`

@author Tirthraj Singh <tirthraj.singh@girnarsoft.com>
@since 2.0
