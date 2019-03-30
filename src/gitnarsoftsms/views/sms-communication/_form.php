<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
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
                            ->dropDownList($smsServices, ['prompt' => 'Select'])
                        ?>
                    </div>
                    <div class="form-group col-md-12">
                        <?= $form->field($model, 'slug')->textInput() ?>
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
                    <?= Html::submitButton(\Yii::t('app', 'Save Form'), ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
   <?php ActiveForm::end(); ?>
</div>