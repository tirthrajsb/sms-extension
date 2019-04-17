<?php
namespace gitnarsoftsms\models\communication;

use yii\data\ActiveDataProvider;

/**
 * SmsCommunication
 *
 * @category  PHP
 * @package   Model
 * @author    Tirthraj Singh <tirthraj.singh@girnarsoft.com>
 * @copyright 2018 GirnarSoft Pvt. Ltd.
 * @license   2018 GirnarSoft Pvt. Ltd.
 * @link      http://www.girnarsoft.com
 */
class SmsCommunicationSearch extends SmsCommunication
{
    public function search($params) {
        $query = SmsCommunication::find();
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

        if($this->ip) {
            $query->andWhere(['like', 'ip', $this->ip]);
        }

        if($this->status) {
            $query->andWhere(['like', 'status', $this->status]);
        }
        
        return $dataProvider;
    }
}