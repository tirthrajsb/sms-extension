<?php
namespace gitnarsoftsms\services;

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use gitnarsoftsms\models\SmsConfig;
use gitnarsoftsms\models\SmsConfigHeader;
use gitnarsoftsms\models\SmsConfigFormData;
use wbraganca\dynamicform\DynamicFormWidget;

/**
 * SmsServices: Set config for send sms
 *
 * @category  PHP
 * @package   SMS
 * @author    Tirthraj Singh <tirthraj.singh@girnarsoft.com>
 * @copyright 2018 GirnarSoft Pvt. Ltd.
 * @license   2018 GirnarSoft Pvt. Ltd.
 * @link      http://www.girnarsoft.com
 */
class SmsServices implements interfaces\ISmsServices
{
    public function create(): void
    {
        $model = new SmsConfig();
        $smsConfigHeader = new SmsConfigHeader();
        $smsConfigFormData = new SmsConfigFormData();
        $this->render($model, [$smsConfigHeader], [$smsConfigFormData]);
    }

    public function render(SmsConfig $model, array $smsConfigHeaders, array $smsConfigFormData): void
    {
        ?>
        <div class="sms-form">
            <?php $form = ActiveForm::begin(['id' => 'sms-config']); ?>
                <div class="box box-success box-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <?= $form->field($model, 'name')->textInput() ?>
                        </div>
                        <div class="form-group col-md-6">
                            <?= $form->field($model, 'slug')->textInput() ?>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-md-6">
                            <?= $form->field($model, 'mobile_prefix')->textInput() ?>
                        </div>
                        <div class="form-group col-md-6">
                            <?= $form->field($model, 'mobile_key')->textInput() ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <?= $form->field($model, 'mobile_prefix')->textInput() ?>
                        </div>
                    </div>
                </div>

                <div class="box box-success box-body">
                    <div class="row">
                        
                        <div class="form-group col-md-2">
                            <?= $form->field($model, 'type')->dropDownList([
                                SmsConfig::TYPE_GET => SmsConfig::TYPE_GET,
                                SmsConfig::TYPE_POST => SmsConfig::TYPE_POST
                            ]) ?>
                        </div>

                        <div class="form-group col-md-10">
                            <?= $form->field($model, 'url')->textInput() ?>
                        </div>

                    </div>
                </div>

                <div id="sms-config-header" class="box box-success box-body">
                    <div class="panel panel-default">
                        <div class="panel-heading"><h4><?= \Yii::t('app', 'Headers') ?></h4></div>
                        <div class="panel-body">
                            <?php DynamicFormWidget::begin([
                                'widgetContainer' => 'smsconfig_wrapper',
                                'widgetBody' => '.container-items',
                                'widgetItem' => '.item',
                                'limit' => 4,
                                'min' => 1,
                                'insertButton' => '.add-item',
                                'deleteButton' => '.remove-item',
                                'model' => $smsConfigHeaders[0],
                                'formId' => 'sms-config-header',
                                'formFields' => [
                                    'header_key',
                                    'header_value',
                                    'description'
                                ],
                            ]); ?>

                            <div class="container-items"><!-- widgetContainer -->
                            <?php foreach ($smsConfigHeaders as $i => $smsConfigHeader): ?>
                                <div class="item panel panel-default"><!-- widgetBody -->
                                    <div class="panel-heading">
                                        <div class="pull-right">
                                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="panel-body">
                                        <?php
                                            // necessary for update action.
                                            if (!$smsConfigHeader->isNewRecord) {
                                                echo Html::activeHiddenInput($smsConfigHeader, "[{$i}]id");
                                            }
                                        ?>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <?= $form->field($smsConfigHeader, "[{$i}]header_key")->textInput()->label(\Yii::t('app', 'Key')) ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <?= $form->field($smsConfigHeader, "[{$i}]header_value")->textInput()->label(\Yii::t('app', 'Value')) ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <?= $form->field($smsConfigHeader, "[{$i}]description")->textInput()->label(\Yii::t('app', 'Description')) ?>
                                            </div>
                                        </div><!-- .row -->
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            </div>
                            <?php DynamicFormWidget::end(); ?>
                        </div>
                    </div>
                </div>

                <div id="form-data-config" class="box box-success box-body">
                    <div class="panel panel-default">
                        <div class="panel-heading"><h4><?= \Yii::t('app', 'Form Data') ?></h4></div>
                        <div class="panel-body">
                            <?php DynamicFormWidget::begin([
                                'widgetContainer' => 'smsconfig_wrapper',
                                'widgetBody' => '.container-items',
                                'widgetItem' => '.item',
                                'limit' => 4,
                                'min' => 1,
                                'insertButton' => '.add-item',
                                'deleteButton' => '.remove-item',
                                'model' => $smsConfigFormData[0],
                                'formId' => 'form-data-config',
                                'formFields' => [
                                    'data_key',
                                    'data_value',
                                    'description'
                                ],
                            ]); ?>

                            <div class="container-items"><!-- widgetContainer -->
                            <?php foreach ($smsConfigFormData as $i => $formData): ?>
                                <div class="item panel panel-default"><!-- widgetBody -->
                                    <div class="panel-heading">
                                        <div class="pull-right">
                                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="panel-body">
                                        <?php
                                            // necessary for update action.
                                            if (!$formData->isNewRecord) {
                                                echo Html::activeHiddenInput($formData, "[{$i}]id");
                                            }
                                        ?>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <?= $form->field($formData, "[{$i}]data_key")->textInput()->label(\Yii::t('app', 'Key')) ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <?= $form->field($formData, "[{$i}]data_value")->textInput()->label(\Yii::t('app', 'Value')) ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <?= $form->field($formData, "[{$i}]description")->textInput()->label(\Yii::t('app', 'Description')) ?>
                                            </div>
                                        </div><!-- .row -->
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            </div>
                            <?php DynamicFormWidget::end(); ?>
                        </div>
                    </div>
                </div>

                <div class="box box-success box-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <?= Html::submitButton(\Yii::t('app', 'Save Form'), ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
        <?php
    }
}