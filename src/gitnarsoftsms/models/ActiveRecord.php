<?php
namespace gitnarsoftsms\models;

use yii\helpers\Inflector;

/**
 * ActiveRecord: Default model calss for all models
 *
 * @category  PHP
 * @package   model
 * @author    Tirthraj Singh <tirthraj.singh@girnarsoft.com>
 * @copyright 2018 GirnarSoft Pvt. Ltd.
 * @license   2018 GirnarSoft Pvt. Ltd.
 * @link      http://www.girnarsoft.com
 */
class ActiveRecord extends \yii\mongodb\ActiveRecord
{
    /**
     * To get constant list based on constant prefix and class name.
     *
     * @param string $prefix    constant prefix
     * @param string $className class name
     *
     * @return array $constantList
     */
    public static function getConstantList($prefix, $className, $value = null)
    {
        $constantList = [];
        $prefixLength = strlen($prefix);
        $reflection = new \ReflectionClass($className);
        $constants = $reflection->getConstants();
        foreach ($constants as $name => $val) {
            if (substr($name, 0, $prefixLength) != $prefix) {
                continue;
            }
            $constantList[$val] = Inflector::humanize(strtolower(str_replace($prefix, '', $name)));
        }
        
        if ($value) {
            return $constantList[$value];
        }
        return $constantList;
    }
}