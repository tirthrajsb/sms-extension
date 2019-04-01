<?php
$this->title = \Yii::t('app', 'Update SMS Communication');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'SMS Communication List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'View SMS Communication'), 'url' => ['view', 'id' => (string) $model->_id]];
$this->params['breadcrumbs'][] = $this->title;

echo $this->render('_form', [
    'model' => $model,
    'smsServices' => $smsServices
]);
