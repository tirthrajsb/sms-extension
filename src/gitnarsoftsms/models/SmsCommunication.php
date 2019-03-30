<?php
namespace gitnarsoftsms\models;

use yii\mongodb\ActiveRecord;
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

    public static function collectionName()
    {
        return 'sms_communication';
    }

    public function rules()
    {
        return [
            [['sms_config_id', 'slug', 'description'], 'required'],
            ['slug', 'unique'],
            [['updated_at', 'created_at'], 'integer']
        ];
    }

    public function attributes()
    {
        return ['_id', 'sms_config_id', 'slug', 'description', 'updated_at', 'created_at'];
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
                    'updated_at' => AttributeTypecastBehavior::TYPE_INTEGER,
                    'created_at' => AttributeTypecastBehavior::TYPE_INTEGER,
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