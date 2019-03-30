<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\mongodb\Query;

$this->title = \Yii::t('app', 'View SMS Config');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'SMS Config List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coupon box box-success box-body">
    <p>
        <?= Html::a(\Yii::t('app', 'Update'), ['update', 'id' => (string) $model->_id], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'timeout',
            'type',
            'url',
            'updated_at:date',
            'created_at:date'
        ],
    ]) ?>
</div>
<div class="coupon box box-success box-body">
    <h3><?= \Yii::t('app', 'Headers') ?></h3>
    <?= GridView::widget([
        'dataProvider' => (new ActiveDataProvider([
            'query' => ((new Query())->from('sms_config_header')->where(['sms_config_id' => (string) $model->_id])),
        ])),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'header_key',
            'header_value',
            'description'
        ]
    ]) ?>
</div>

<div class="coupon box box-success box-body">
    <h3><?= \Yii::t('app', 'Form Data') ?></h3>
    <?= GridView::widget([
        'dataProvider' => (new ActiveDataProvider([
            'query' => ((new Query())->from('sms_config_form_data')->where(['sms_config_id' => (string) $model->_id])),
        ])),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'data_key',
            'data_value',
            'description'
        ]
    ]) ?>
</div>