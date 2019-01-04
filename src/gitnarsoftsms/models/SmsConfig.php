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
class SmsConfig extends ActiveRecord
{
    const TYPE_GET = 'GET';
    const TYPE_POST = 'POST';

    public static function collectionName()
    {
        return 'sms_config';
    }

    public function rules()
    {
        return [
            [['name', 'slug', 'type', 'url', 'updated_at', 'created_at'], 'required'],
            [['updated_at', 'created_at'], 'integer'],
        ];
    }

    public function attributes()
    {
        return ['_id', 'name', 'slug', 'type', 'url', 'updated_at', 'created_at'];
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

    public static function find()
    {
        return new FormQuery(get_called_class());
    }
}