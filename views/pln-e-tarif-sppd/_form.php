<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\export\ExportMenu;
use kartik\widgets\DatePicker;
use kartik\widgets\FileInput;
use app\models\Admin;
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
        'action'=>$model->isNewRecord ? ['pln-e-tarif-sppd/create'] : ['pln-e-tarif-sppd/update','id'=>$model->ID],
        'options'=>['id' =>  'upload-payroll-form','enableAjaxValidation'=>true,'enctype'=>'multipart/form-data']
    ]); ?>

    <?= $form->field($model, 'KONSUMSI')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LAUNDRY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TRANPORTASI_BANDARA_PELABUHAN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TRANSPORTASI_TERMINAL')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-save"></span> Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
