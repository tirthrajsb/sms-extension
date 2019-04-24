<?php
namespace gitnarsoftsms\models\log;

use yii\behaviors\AttributeTypecastBehavior;
use yii\behaviors\TimestampBehavior;
use gitnarsoftsms\models\ActiveRecord;

/**
 * SmsLog
 *
 * @category  PHP
 * @package   Model
 * @author    Tirthraj Singh <tirthraj.singh@girnarsoft.com>
 * @copyright 2018 GirnarSoft Pvt. Ltd.
 * @license   2018 GirnarSoft Pvt. Ltd.
 * @link      http://www.girnarsoft.com
 */
class SmsLog extends ActiveRecord
{

    public static function collectionName()
    {
        return 'sms_log';
    }

    public function rules()
    {
        return [
            [['username', 'ip', 'request', 'response'], 'required'],
            [['updated_at', 'created_at'], 'integer']
        ];
    }

    public function attributes()
    {
        return ['_id', 'username', 'ip', 'request', 'response', 'updated_at', 'created_at'];
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
}