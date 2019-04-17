<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = \Yii::t('app', 'SMS Config List');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="coupon box box-success box-body">
    <h3><?= \Yii::t('app', 'Form Data') ?></h3>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $model,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'type',
            'response_format',
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