<?php
namespace gitnarsoftsms\models\config;

use yii\data\ActiveDataProvider;

/**
 * SmsConfig
 *
 * @category  PHP
 * @package   Model
 * @author    Tirthraj Singh <tirthraj.singh@girnarsoft.com>
 * @copyright 2018 GirnarSoft Pvt. Ltd.
 * @license   2018 GirnarSoft Pvt. Ltd.
 * @link      http://www.girnarsoft.com
 */
class SmsConfigSearch extends SmsConfig
{
    public function search($params) {
        $query = SmsConfig::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['_id' => SORT_DESC]],
            'pagination' => [
                'pageSize' => 20,
            ]
        ]);
    
        $this->load($params);
    
        if($this->name) {
            $query->andWhere(['like', 'name', $this->name]);
        }

        if($this->type) {
            $query->andWhere(['like', 'type', $this->name]);
        }

        if($this->response_format) {
            $query->andWhere(['like', 'response_format', $this->name]);
        }
        
        return $dataProvider;
    }
}