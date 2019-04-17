<?php
use yii\helpers\Html;
use yii\grid\GridView;
use gitnarsoftsms\models\communication\SmsCommunication;

$this->title = \Yii::t('app', 'SMS Communication List');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="coupon box box-success box-body">
    <h3><?= \Yii::t('app', 'Form Data') ?></h3>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $model,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'SMS Service',
                'value' => 'smsConfig.name',
            ],
            'username',
            'ip',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    $status = SmsCommunication::getConstantList('STATUS_', SmsCommunication::className());
                    return $status[$model['status']];
                },
                'filter' => Html::activeDropDownList($model, 'status', SmsCommunication::getConstantList('STATUS_', SmsCommunication::className()), ['class' => 'form-control', 'prompt' => 'All']),
            ],
            [
                'attribute'=>'updated_at',
                'value'=> function($model) {
                    return date('M d, Y', $model['updated_at']);
                },
                'filter'=>false,
            ],
            [
                'attribute'=>'created_at',
                'value'=> function($model) {
                    return date('M d, Y', $model['created_at']);
                },
                'filter'=>false,
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view_form} {update_form}',
                'buttons' => [
                    'view_form' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            ['view', 'id' => $model['_id']->__toString()],
                            ['title' => \Yii::t('app', 'View Form'), 'class' => 'btn btn-primary']
                        );
                    },
                    'update_form' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            ['update', 'id' => $model['_id']->__toString()],
                            ['title' => \Yii::t('app', 'Update Form'), 'class' => 'btn btn-primary']
                        );
                    }
                ],
            ]
        ]
    ]) ?>
</div>