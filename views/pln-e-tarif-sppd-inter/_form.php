<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\export\ExportMenu;
use kartik\widgets\DatePicker;
use kartik\widgets\FileInput;
use app\models\PlnERegion;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Payroll */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="sppd-form">

    <?php $form = ActiveForm::begin([
        'type'=>ActiveForm::TYPE_VERTICAL, 
        'formConfig'=>['labelSpan'=>4],
        'action'=>$model->isNewRecord ? ['pln-e-tarif-sppd-inter/create'] : ['pln-e-tarif-sppd-inter/update','id'=>$model->ID],
        'options'=>['id' =>  'upload-payroll-form','enableAjaxValidation'=>true,'enctype'=>'multipart/form-data']
    ]); ?>

    <?= $form->field($model, 'REGION')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(PlnERegion::find()->select('ID,REGION')->groupBy('ID')->asArray()->all(), 'ID', 'REGION'),
            'options' => ['placeholder' => '','id' => $model->isNewRecord ? 'create-ID_VP' : 'update-ID_VP'],
            'pluginOptions' => [
                'allowClear' => false
            ],
        ]) 
    ?>

    <?= $form->field($model, 'KONSUMSI')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UANG_SAKU')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-save"></span> Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
