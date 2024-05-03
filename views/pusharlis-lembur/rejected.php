<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;
use kartik\widgets\FileInput;
use app\models\KsoLembagaSertifikasi;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use app\models\KsoKodeKompetensiTeknik;
use app\models\KsoPegawaiSearch;
use yii\helpers\Url;

$model->scenario = "rejected";
?>

<div class="kso-sertifikasi-teknik-form">
    <?php 
        $form = ActiveForm::begin([
            'type' => ActiveForm::TYPE_VERTICAL,
            'action'=>['pusharlis-lembur/update-tolak'],
            'options'=>[
                'id' =>  'tolak-lembur',
                'enableAjaxValidation'=>true,
                'enctype'=>'multipart/form-data'
            ]
        ]); 
    ?>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'ALASAN')->textArea(['row' => 2]) ?>
        </div>
        <div class="col-md-12">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success','name'=>'hp','value'=>'hp']) ?>
            <?= $form->field($model, 'ID')->hiddenInput()->label(false) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
