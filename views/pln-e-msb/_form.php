<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\export\ExportMenu;
use kartik\widgets\DatePicker;
use kartik\widgets\FileInput;
use app\models\PlnEVp;
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
        'action'=>$model->isNewRecord ? ['pln-e-msb/create'] : ['pln-e-msb/update','id'=>$model->ID],
        'options'=>['id' =>  'upload-payroll-form','enableAjaxValidation'=>true,'enctype'=>'multipart/form-data']
    ]); ?>

    <?= $form->field($model, 'ID_VP')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(PlnEVp::find()->select('ID,NAMA')->groupBy('ID')->asArray()->all(), 'ID', 'NAMA'),
            'options'=>['placeholder'=>'pilih ...'],
            'pluginOptions' => [
                'allowClear' => false
            ],
        ]) 
    ?>
    
    <?= $form->field($model, 'NAMA')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-save"></span> Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
