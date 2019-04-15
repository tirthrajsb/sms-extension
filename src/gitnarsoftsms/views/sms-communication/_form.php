<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use gitnarsoftsms\models\SmsCommunication;
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
                        <?= 
                        $form->field($model, 'sms_config_id')
                            ->dropDownList($smsService, ['prompt' => 'Select'])
                            ->label(\Yii::t('app', 'SMS Service'))
                        ?>
                    </div>
                    <div class="form-group col-md-12">
                        <?= $form->field($model, 'username')->textInput() ?>
                    </div>
                    <?php if ($model->isNewRecord) : ?>
                        <div class="form-group col-md-12">
                            <?= $form->field($model, 'password')->passwordInput() ?>
                        </div>

                        <div class="form-group col-md-12">
                            <?= $form->field($model, 'confirmPassword')->passwordInput() ?>
                        </div>
                    <?php endif; ?>

                    <div class="form-group col-md-12">
                        <?= $form->field($model, 'ip')->textInput()->label(\Yii::t('app', 'IP (comma separated or leave blank for no restriction)')) ?>
                    </div>

                    <div class="form-group col-md-12">
                        <?=
                        $form->field($model, 'status')
                            ->dropDownList(SmsCommunication::getConstantList('STATUS_', SmsCommunication::className()))
                        ?>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="form-group col-md-12">
                        <?= $form->field($model, 'description')->textArea(['rows' => 7]) ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <?= Html::submitButton(\Yii::t('app', ($model->isNewRecord ? 'Create' : 'Update')), ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
   <?php ActiveForm::end(); ?>
</div>