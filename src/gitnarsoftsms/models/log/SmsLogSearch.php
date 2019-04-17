<?php
namespace gitnarsoftsms\models\log;

use yii\data\ActiveDataProvider;

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
class SmsLogSearch extends SmsLog
{
    public function search($params) {
        $query = SmsLog::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['_id' => SORT_DESC]],
            'pagination' => [
                'pageSize' => 20,
            ]
        ]);
    
        $this->load($params);
    
        if($this->username) {
            $query->andWhere(['like', 'username', $this->username]);
        }
        
        return $dataProvider;
    }
}