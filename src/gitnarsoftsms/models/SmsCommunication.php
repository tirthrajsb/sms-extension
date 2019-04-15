<?php
namespace gitnarsoftsms\models;

use yii\behaviors\AttributeTypecastBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * Form
 *
 * @category  PHP
 * @package   Model
 * @author    Tirthraj Singh <tirthraj.singh@girnarsoft.com>
 * @copyright 2018 GirnarSoft Pvt. Ltd.
 * @license   2018 GirnarSoft Pvt. Ltd.
 * @link      http://www.girnarsoft.com
 */
class SmsCommunication extends ActiveRecord
{
    public $confirmPassword;

    const STATUS_ENABLE = 1;
    const STATUS_DISABLE = 0;

    public static function collectionName()
    {
        return 'sms_communication';
    }

    public function rules()
    {
        return [
            [['sms_config_id', 'username', 'password', 'description', 'status'], 'required'],
            ['username', 'unique'],
            ['confirmPassword', 'required', 'on' => 'create'],
            ['confirmPassword', 'compare', 'compareAttribute'=>'password', 'message' => \Yii::t('app', "Passwords don't match")],
            [['updated_at', 'created_at'], 'integer'],
            [['ip'], 'safe']
        ];
    }

    public function attributes()
    {
        return ['_id', 'sms_config_id', 'username', 'password', 'ip', 'description', 'status', 'updated_at', 'created_at'];
    }

    /**
     * To get behaviours.
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'TimestampBehavior' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
            ],
            'typecast' => [
                'class' => AttributeTypecastBehavior::className(),
                'attributeTypes' => [
                    'status' => AttributeTypecastBehavior::TYPE_INTEGER,
                    'updated_at' => AttributeTypecastBehavior::TYPE_INTEGER,
                    'created_at' => AttributeTypecastBehavior::TYPE_INTEGER
                ],
                'typecastAfterValidate' => true,
                'typecastBeforeSave' => false,
                'typecastAfterFind' => false,
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSmsConfig()
    {
        return $this->hasOne(SmsConfig::className(), ['_id' => 'sms_config_id']);
    }
}