<?php
namespace gitnarsoftsms\services;

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use gitnarsoftsms\models\SmsConfig;
use gitnarsoftsms\models\SmsConfigHeader;
use gitnarsoftsms\models\SmsConfigFormData;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\data\ActiveDataProvider;
use yii\mongodb\Query;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

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
    /**
     * save: Save sms config data & headers
     * 
     * @access public
     * 
     * @param array $data
     * 
     * @return SmsConfig
     */
    public function save(array $data): SmsConfig
    {
        if(!empty($data['SmsConfig']['_id'])) {
            $model = SmsConfig::findOne($data['SmsConfig']['_id']);
        } else {
            $model = new SmsConfig();
        }

        $model->load($data);
        
        if($model->save()) {
            $this->saveSmsConfigFormData($model, $data['SmsConfigFormData']);
            $this->saveSmsConfigHeader($model, $data['SmsConfigHeader']);
        }
        
        return $model;
    }

    /**
     * saveSmsConfigFormData: Save sms config form data values for get/post
     * 
     * @access private
     * 
     * @param SmsConfig $smsConfig
     * @param array $data
     * 
     * @return void
     */
    private function saveSmsConfigFormData(SmsConfig $smsConfig, array $data): void
    {
        SmsConfigFormData::deleteAll(['sms_config_id' => (string) $smsConfig->_id]);

        foreach($data as $row) {
            if(!empty($row['data_key'])) {
                $model = new SmsConfigFormData();
                $model->load(['SmsConfigFormData' => $row]);
                $model->sms_config_id = (string) $smsConfig->_id;
                $model->save();
            }
        }
    }

    /**
     * saveSmsConfigHeader: Save sms config headers for get/post
     * 
     * @access private
     * 
     * @param SmsConfig $smsConfig
     * @param array $data
     * 
     * @return void
     */
    private function saveSmsConfigHeader(SmsConfig $smsConfig, array $data): void
    {
        SmsConfigHeader::deleteAll(['sms_config_id' => (string) $smsConfig->_id]);

        foreach($data as $row) {
            if(!empty($row['header_key'])) {
                $model = new SmsConfigHeader();
                $model->load(['SmsConfigHeader' => $row]);
                $model->sms_config_id = (string) $smsConfig->_id;
                $model->save();
            }
        }
    }

    /**
     * list: Show list of all sms configration
     * 
     * @access public
     * 
     * @return void
     */
    public function list(): void
    {
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
        <?php
    }

    /**
     * view: Show single sms configration by id
     * 
     * @access public
     * 
     * @return void
     */
    public function view(string $id): void
    {
        $model = SmsConfig::findOne($id);

        if (!$model) {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }
        ?>
        <div class="coupon box box-success box-body">
            <p>
                <?= Html::a(\Yii::t('app', 'Update'), ['update', 'id' => (string) $model->_id], ['class' => 'btn btn-primary']) ?>
            </p>
            <?= \yii\widgets\DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'name',
                    'slug',
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
        <?php
    }

    /**
     * create: Render sms config form for new config
     * 
     * @access public
     * 
     * @return void
     */
    public function create(): void
    {
        $model = new SmsConfig();

        if (\Yii::$app->request->isPost) {
            $model->load(\Yii::$app->request->post());
            $model->validate();
        }
        
        $smsConfigHeader = new SmsConfigHeader();
        $smsConfigFormData = new SmsConfigFormData();
        $this->render($model, [$smsConfigHeader], [$smsConfigFormData]);
    }

    /**
     * update: Show sms config form for update current configration
     * 
     * @access public
     * 
     * @param string $id
     * 
     * @return void
     */
    public function update(string $id): void
    {
        $model = SmsConfig::findOne($id);

        if (!$model) {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }

        if (\Yii::$app->request->isPost) {
            $model->load(\Yii::$app->request->post());
            $model->validate();
        }
        
        $smsConfigHeader = $model->smsConfigHeaders ? $model->smsConfigHeaders : [(new SmsConfigHeader())];
        $smsConfigFormData = $model->smsConfigFormData ? $model->smsConfigFormData : [(new SmsConfigFormData())];
        $this->render($model, $smsConfigHeader, $smsConfigFormData);
    }

    /**
     * render: Render sms config form for both create & update
     * 
     * @access public
     * @param SmsConfig $model
     * @param array $smsConfigHeaders
     * @param array $smsConfigFormData
     * 
     * @return void
     */
    public function render(SmsConfig $model, array $smsConfigHeaders, array $smsConfigFormData): void
    {
        ?>
        <div class="sms-form">
            <?php $form = ActiveForm::begin(['id' => 'sms-config']); ?>
                <?php if (!$model->isNewRecord): ?>
                    <?= $form->field($model, '_id')->hiddenInput()->label(false) ?>
                <?php endif; ?>
                <div class="box box-success box-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <?= $form->field($model, 'name')->textInput() ?>
                        </div>
                        <div class="form-group col-md-4">
                            <?= $form->field($model, 'slug')->textInput() ?>
                        </div>
                        <div class="form-group col-md-4">
                            <?= $form->field($model, 'timeout')->textInput() ?>
                        </div>
                    </div>
                </div>

                <div class="box box-success box-body">
                    <div class="row">
                        
                        <div class="form-group col-md-2">
                            <?= $form->field($model, 'type')->dropDownList([
                                SmsConfig::TYPE_GET => SmsConfig::TYPE_GET,
                                SmsConfig::TYPE_POST => SmsConfig::TYPE_POST,
                                SmsConfig::TYPE_JSON => SmsConfig::TYPE_JSON
                            ])->label(\Yii::t('app', 'Request Type')) ?>
                        </div>

                        <div class="form-group col-md-10">
                            <?= $form->field($model, 'url')->textInput() ?>
                        </div>

                    </div>
                </div>

                <div id="form-data-config" class="box box-success box-body">
                    <div class="panel panel-default">
                        <div class="panel-heading"><h4><?= \Yii::t('app', 'Form Data') ?></h4></div>
                        <div class="panel-body">
                            <?php DynamicFormWidget::begin([
                                'widgetContainer' => 'smsconfig_data_wrapper',
                                'widgetBody' => '.container-items',
                                'widgetItem' => '.item',
                                'limit' => 50,
                                'min' => 1,
                                'insertButton' => '.add-item',
                                'deleteButton' => '.remove-item',
                                'model' => $smsConfigFormData[0],
                                'formId' => 'sms-config',
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
                                                echo Html::activeHiddenInput($formData, "[{$i}]_id");
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

                <div id="sms-config-header" class="box box-success box-body">
                    <div class="panel panel-default">
                        <div class="panel-heading"><h4><?= \Yii::t('app', 'Headers') ?></h4></div>
                        <div class="panel-body">
                            <?php DynamicFormWidget::begin([
                                'widgetContainer' => 'smsconfig_header_wrapper',
                                'widgetBody' => '.container-items',
                                'widgetItem' => '.item',
                                'limit' => 50,
                                'min' => 1,
                                'insertButton' => '.add-item',
                                'deleteButton' => '.remove-item',
                                'model' => $smsConfigHeaders[0],
                                'formId' => 'sms-config',
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
                                                echo Html::activeHiddenInput($smsConfigHeader, "[{$i}]_id");
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

                <div class="box box-success box-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <?= Html::submitButton(\Yii::t('app', 'Save Form'), ['class' => 'btn btn-primary']) ?>
                            <?= Html::button(\Yii::t('app', 'Check'), ['id' => 'gs-sms-check','class' => 'btn btn-primary', 'type' => 'button']) ?>
                        </div>
                    </div>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
        <script>
            document.getElementById('gs-sms-check').addEventListener('click', function() {
                $.ajax({
                    url: "<?= Url::to('check') ?>",
                    type: 'post',
                    dataType: 'json',
                    data: $('form#sms-config').serialize(),
                    before: function() {

                    },
                    success: function(data) {
                        if(data['response']) {
                            alert(data['response']);
                        } else if(data['exception']) {
                            alert(data['exception']);
                        }
                    }
                });
            });
        </script>
        <?php
    }

    /**
     * check: Check sms config by hitting data to sms service
     * 
     * @access public
     * 
     * @param array $data
     * 
     * @return array
     */
    public function check(array $data): array
    {
        $data['SmsConfig'] = $data['SmsConfig'] ?? [];
        $data['SmsConfigFormData'] = $data['SmsConfigFormData'] ?? [];
        $data['SmsConfigHeader'] = $data['SmsConfigHeader'] ?? [];

        return $this->send($data);
    }

    /**
     * sendSms: Send sms to user and get sms config info by slug
     * 
     * @access public
     * 
     * @param string $slug
     * @param array $array
     * 
     * @return array
     */
    public function sendSms(string $slug, array $data): array
    {
        $model = SmsConfig::findOne(['slug' => $slug]);

        if (!$model) {
            throw new \yii\web\NotFoundHttpException("$slug: Configration not availabel");
        }

        $params['SmsConfig'] = $model->attributes;
        $params['SmsConfigFormData'] = [];
        $params['SmsConfigHeader'] = [];

        if($model->smsConfigFormData) {
            foreach($model->smsConfigFormData as $formData) {
                $params['SmsConfigFormData'][] = [
                    'data_key' => $formData->data_key,
                    'data_value' => \Yii::t('app', $formData->data_value, $data),
                ];
            }
        }

        if($model->smsConfigHeaders) {
            foreach($model->smsConfigHeaders as $headers) {
                $params['SmsConfigHeader'][] = $headers->attributes;
            }
        }

        return $this->send($params);
    }

    /**
     * send: Send sms to user
     * 
     * @access private
     * 
     * @param array $data
     * 
     * @return array
     */
    private function send(array $data): array
    {
        try {
            $url = $data['SmsConfig']['url'];
            $postData = ArrayHelper::map($data['SmsConfigFormData'], 'data_key', 'data_value');
            
            //Create uri
            if ($data['SmsConfig']['type'] == SmsConfig::TYPE_GET) {
                $url .= '?' . http_build_query($postData);
            }
            
            //Init curl
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, $data['SmsConfig']['timeout']);

            //Set post fields
            if ($data['SmsConfig']['type'] == SmsConfig::TYPE_POST) {
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
            } elseif($data['SmsConfig']['type'] == SmsConfig::TYPE_JSON) {
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postData));
            }

            //Set header's
            if($data['SmsConfigHeader']) {
                $headers = [];
                foreach($data['SmsConfigHeader'] as $header) {
                    $headers[] = $header['header_key'] . ':' . $header['header_value'];
                }

                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            }

            //Execute curl
            $response = curl_exec($curl);
            curl_close($curl);

            return ['response' => $response];
        } catch (Exception $e) {
            return ['exception' => $e];
        }
    }
}