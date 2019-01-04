<?php
namespace gitnarsoftsms\services;

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use gitnarsoftsms\models\SmsConfig;

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
    public static function create(): void
    {
        $model = new \gitnarsoftsms\models\SmsConfig();

        echo '<div class="sms-form">';
            $form = ActiveForm::begin(['id' => 'frm-coupon']);
                echo '<div class="box box-success box-body">';
                    echo '<div class="row">';
                        
                        echo '<div class="form-group col-md-6">';
                            echo $form->field($model, 'name')->textInput();
                        echo '</div>';

                        echo '<div class="form-group col-md-6">';
                            echo $form->field($model, 'slug')->textInput();
                        echo '</div>';

                    echo '</div>';
                echo '</div>';

                echo '<div class="box box-success box-body">';
                    echo '<div class="row">';
                        
                        echo '<div class="form-group col-md-2">';
                            echo $form->field($model, 'type')->dropDownList([
                                SmsConfig::TYPE_GET => SmsConfig::TYPE_GET,
                                SmsConfig::TYPE_POST => SmsConfig::TYPE_POST
                            ]);
                        echo '</div>';

                        echo '<div class="form-group col-md-10">';
                            echo $form->field($model, 'url')->textInput();
                        echo '</div>';

                    echo '</div>';
                echo '</div>';

                echo '<div class="box box-success box-body">';
                    echo '<div class="row">';
                        echo '<div class="form-group col-md-12">';
                            echo Html::submitButton(\Yii::t('app', 'Save Form'), ['class' => 'btn btn-primary']);
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            ActiveForm::end();
        echo "</div>";
    }
}