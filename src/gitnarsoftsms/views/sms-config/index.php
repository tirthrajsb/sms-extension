<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\mongodb\Query;

$this->title = \Yii::t('app', 'SMS Config List');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="coupon box box-success box-body">
    <h3><?= \Yii::t('app', 'Form Data') ?></h3>
    <?= GridView::widget([
        'dataProvider' => (new ActiveDataProvider([
            'query' => ((new Query())->from('sms_config')),
        ])),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'slug',
            'type',
            'updated_at:date',
            'created_at:date',
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