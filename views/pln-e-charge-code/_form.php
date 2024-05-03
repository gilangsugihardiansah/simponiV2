<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\export\ExportMenu;
use kartik\widgets\DatePicker;
use kartik\widgets\FileInput;
use app\models\PlnEVp;
use app\models\PlnEMsb;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Payroll */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="sppd-form">

    <?php $form = ActiveForm::begin([
        'type'=>ActiveForm::TYPE_VERTICAL, 
        'formConfig'=>['labelSpan'=>4],
        'action'=>$model->isNewRecord ? ['pln-e-charge-code/create'] : ['pln-e-charge-code/update','id'=>$model->ID],
        'options'=>['id' =>  'upload-payroll-form','enableAjaxValidation'=>true,'enctype'=>'multipart/form-data']
    ]); ?>
    <?= $form->field($model, 'CHARGE_CODE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ID_VP')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(PlnEVp::find()->select('ID,NAMA')->groupBy('ID')->asArray()->all(), 'ID', 'NAMA'),
            'options' => ['placeholder' => '','id' => $model->isNewRecord ? 'create-ID_VP' : 'update-ID_VP'],
            'pluginOptions' => [
                'allowClear' => false
            ],
        ]) 
    ?>

    <?= $form->field($model, 'ID_MSB')->widget(DepDrop::classname(), [
            'options' => ['placeholder' => 'Select ...'],
            'type' => DepDrop::TYPE_SELECT2,
            'select2Options' => ['pluginOptions' => ['allowClear' => true]],
            'pluginOptions' => [
                'depends' => [
                    $model->isNewRecord ? 'create-ID_VP' : 'update-ID_VP',
                ],
                'initialize' => true,
                'url' => Url::to(['/pln-e-msb/child-account']),
                'params' => ['ID_VP'],
                'loadingText' => 'Select ...',
            ]
        ]);
    ?>

    <?= $form->field($model, 'NAMA_PEKERJAAN')->textArea(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-save"></span> Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
