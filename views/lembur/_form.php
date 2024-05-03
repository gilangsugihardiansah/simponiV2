<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Url; 
use kartik\select2\Select2;
use kartik\daterange\DateRangePicker;
use app\models\DVal;
use kartik\widgets\TypeaheadBasic;

/* @var $this yii\web\View */
/* @var $model app\models\DataPengajuanSppd */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'No. Lembur',
]) . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Data Pengajuan Lembur', 'url' => ['index-app']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="form-box">
    <?php 
        $form = ActiveForm::begin([
            'type' => ActiveForm::TYPE_VERTICAL,
            'options'=>[
                'id' =>  'app-lembur',
                'enableAjaxValidation'=>true,
                'enctype'=>'multipart/form-data'
            ]
        ]); 
    ?>
    <div class="row" style="font-size: 10px;">
        <div class="col-md-12">
            <h3><?=$this->title?></h3>
        </div>
        <div class="col-md-12"> <i>Data Tenaga Kerja</i></div>
        <div class="col-md-12">
            <?= $form->field($model, 'NO_INDUK')->textInput(['readOnly' => true]) ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'NAMA')->textInput(['readOnly' => true]) ?>
        </div>
        <div class="col-md-12">
            <hr/>
        </div>
        <div class="col-md-12"> <i>Data Lembur</i></div>
        <div class="col-md-12">
            <?= 
                $form->field($model, 'JAM_AWAL_LEMBUR')->widget(DateRangePicker::classname(), [
                    'convertFormat'=>true,
                    'pluginOptions' => [
                        'language' => 'id',
                        'timePicker'=>true,
                        'timePickerIncrement'=>1,
                        'locale'=>['format'=>'Y-m-d H:i:s'],
                        'autoclose' => true,
                        'todayHighlight' => true,
                        'timePicker24Hour'=>true,
                    ],
                ])->label('Jam Lembur'); 
            ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'JENIS_LEMBUR')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(DVal::find()->andWhere(['DESCRIPTION'=>'JENIS_LEMBUR'])->andWhere(['TABLE'=>'lembur'])->all(), 'KEY', 'VALUE'),
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]) 
            ?>
        </div> 
        <div class="col-md-12">
            <hr/>
        </div>
        <div class="col-md-12"> <i>Detail Lembur</i></div>
        <div class="col-md-12">
            <?= $form->field($model, 'PEKERJAAN_LEMBUR')->textarea(['rows' => 5]) ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'ALAMAT')->textarea(['rows' => 5]) ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'URAIAN_TUGAS_LEMBUR')->textarea(['rows' => 5]) ?>
        </div>
        <div class="col-md-12">
            <hr/>
        </div>
    </div>

    <div class="row" style="margin-right: 0px;">
        <div class="col-md-12">
            <?= $form->field($model, 'STATUS_PENGAJUAN')->hiddenInput(['value' => 'Menunggu Upload Realisasi'])->label(false) ?>
            <?=
                Html::submitButton('<span class="glyphicon glyphicon-ok"></span>'. Yii::t('app', ' Update'), ['class' => 'btn btn-sm btn-primary'])
            ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<br/>

<?php
    $this->registerJs('
        document.addEventListener("contextmenu", function(e){
            e.preventDefault();
        }, false);
        document.onkeydown = function(e) {
            if(event.keyCode == 123) {
                return false;
            }
            if(e.ctrlKey && e.shiftKey && e.keyCode == "I".charCodeAt(0)){
                return false;
            }
            if(e.ctrlKey && e.shiftKey && e.keyCode == "J".charCodeAt(0)){
                return false;
            }
            if(e.ctrlKey && e.keyCode == "U".charCodeAt(0)){
                return false;
            }
        };
    ');
?>
