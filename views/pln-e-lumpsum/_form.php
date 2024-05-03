<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\export\ExportMenu;
use kartik\widgets\DatePicker;
use kartik\widgets\FileInput;
use app\models\DVal;
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
        'action'=>$model->isNewRecord ? ['pln-e-lumpsum/create'] : ['pln-e-lumpsum/update','id'=>$model->ID],
        'options'=>['id' =>  'upload-payroll-form','enableAjaxValidation'=>true,'enctype'=>'multipart/form-data']
    ]); ?>

    <?= $form->field($model, 'WILAYAH')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(DVal::find()->andWhere(['TABLE'=>'pln_e_sppd'])->andWhere(['DESCRIPTION'=>'WILAYAH'])->andWhere(['!=','KEY','Internasional'])->groupBy('KEY')->asArray()->all(), 'KEY', 'VALUE'),
            'options' => ['placeholder' => ''],
            'pluginOptions' => [
                'allowClear' => false
            ],
        ]) 
    ?>

    <?= $form->field($model, 'LUMPSUM')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-save"></span> Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
