<?php
$this->title = \Yii::t('app', 'Create SMS Config');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'SMS Config List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

echo $this->render('_form', [
    'model' => $model,
    'smsConfigHeaders' => $smsConfigHeaders,
    'smsConfigFormData' => $smsConfigFormData,
]);
