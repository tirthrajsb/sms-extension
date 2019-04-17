<?php
namespace gitnarsoftsms\models\config;

use yii\behaviors\AttributeTypecastBehavior;
use yii\behaviors\TimestampBehavior;
use gitnarsoftsms\models\ActiveRecord;

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
    const TYPE_JSON = 'JSON';
    const TYPE_XML = 'XML';

    const CODE_SUCCESS = 1;
    const CODE_UNAUTHORIZED = 2;
    const CODE_EXCEPTION = 3;

    public static function collectionName()
    {
        return 'sms_config';
    }

    public function rules()
    {
        return [
            [['name', 'type', 'url', 'response_format', 'timeout'], 'required'],
            [['timeout', 'updated_at', 'created_at'], 'integer']
        ];
    }

    public function attributes()
    {
        return ['_id', 'name', 'type', 'url', 'response_format', 'timeout', 'updated_at', 'created_at'];
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
    public function getSmsConfigHeaders()
    {
        return SmsConfigHeader::find()->where(['sms_config_id' => (string) $this->_id])->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSmsConfigFormData()
    {
        return SmsConfigFormData::find()->where(['sms_config_id' => (string) $this->_id])->all();
    }
}