<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\mongodb\Query;

$this->title = \Yii::t('app', 'View SMS Log');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'SMS Log List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coupon box box-success box-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            [
                'attribute' => 'request',
                'value' => function($model) {
                    return json_encode($model['request']);
                }
            ],
            [
                'attribute' => 'response',
                'value' => function($model) {
                    return json_encode($model['response']);
                }
            ],
            'updated_at:date',
            'created_at:date'
        ],
    ]) ?>
</div>