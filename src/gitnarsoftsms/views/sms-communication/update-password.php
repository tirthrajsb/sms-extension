<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = \Yii::t('app', 'Update Password');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'SMS Communication List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'View SMS Communication'), 'url' => ['view', 'id' => (string) $model->_id]];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="sms-form">
    <?php $form = ActiveForm::begin(['id' => 'sms-config']); ?>
        <?php if (!$model->isNewRecord): ?>
            <?= $form->field($model, '_id')->hiddenInput()->label(false) ?>
        <?php endif; ?>
        <div class="box box-success box-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <div class="form-group col-md-12">
                        <?= $form->field($model, 'password')->passwordInput(['value' => ''])->label('New Password') ?>
                    </div>

                    <div class="form-group col-md-12">
                        <?= $form->field($model, 'confirmPassword')->passwordInput(['value' => '']) ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <?= Html::submitButton(\Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
   <?php ActiveForm::end(); ?>
</div>