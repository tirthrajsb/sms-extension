<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use gitnarsoftsms\models\SmsCommunication;

$this->title = \Yii::t('app', 'View SMS Communication');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'SMS Communication List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coupon box box-success box-body">
    <p>
        <?= Html::a(\Yii::t('app', 'Update'), ['update', 'id' => (string) $model->_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(\Yii::t('app', 'Change Password'), ['update-password', 'id' => (string) $model->_id], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'sms_config_id',
            [
                'label' => 'SMS Service',
                'format' => 'html',
                'value' => function ($model) {
                    return $model->smsConfig->name;
                }
            ],
            'username',
            'ip',
            'description',
            [
                'label' => 'Status',
                'value' => function ($model){
                    $status = SmsCommunication::getConstantList('STATUS_', SmsCommunication::className());
                    return $status[$model->status];
                }
            ],
            'updated_at:date',
            'created_at:date'
        ],
    ]) ?>
</div>
