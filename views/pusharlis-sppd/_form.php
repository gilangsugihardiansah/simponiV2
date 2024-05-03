<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Url; 
use kartik\select2\Select2;
use kartik\widgets\DatePicker;
use app\models\MasterKabupaten;
use kartik\widgets\TypeaheadBasic;
use app\models\DVal;
use app\models\PusharlisWbs;

/* @var $this yii\web\View */
/* @var $model app\models\DataPengajuanSppd */

if($model->STATUS_PENGAJUAN == "3"):
    $model->scenario = "setujui";
endif;

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'No. SPPD',
]) . $model->ID;

?>

<div class="form-box">
    <?php 
        $form = ActiveForm::begin([
            'type' => ActiveForm::TYPE_VERTICAL,
            'options'=>[
                'id' =>  'app-sppd',
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
        <div class="col-md-12"> <i>Data SPPD</i></div>
        <?php if($model->STATUS_PENGAJUAN == "3"):?>
            <div class="col-md-12">
                <?= $form->field($model, 'WBS')->widget(select2::classname(), [
                        'data' => ArrayHelper::map(PusharlisWbs::find()->all(), 'WSB', function($model){return "{$model->WSB} - {$model->KETERANGAN}";}),
                        'pluginOptions' => 
                        [
                            'highlight'=>true,
                            'allowClear' => true,
                        ],
                    ]) 
                ?>
            </div>
        <?php endif; ?>
        <div class="col-md-12">
            <?= $form->field($model, 'STATUS_SPPD')->widget(select2::classname(), [
                    'data' => ArrayHelper::map(DVal::find()->andWhere(['DESCRIPTION'=>'STATUS_SPPD'])->andWhere(['TABLE'=>'pusharlis_sppd'])->all(), 'KEY', 'VALUE'),
                    'pluginOptions' => 
                    [
                        'highlight'=>true,
                        'allowClear' => true,
                    ],
                ]) 
            ?>
        </div>
        <div class="col-md-12">
            <?= 
                $form->field($model, 'TGL_BERANGKAT')->widget(DatePicker::classname(), [
                    'attribute' => 'TGL_BERANGKAT',
                    'attribute2' => 'TGL_KEMBALI',
                    'separator' => '<i class="glyphicon glyphicon-resize-horizontal"></i>',
                    'type' => DatePicker::TYPE_RANGE,
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true,
                        'todayHighlight' => true
                    ],
                ])->label('Tanggal SPPD'); 
            ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'KOTA_ASAL')->widget(TypeaheadBasic::classname(), [
                    'data' => ArrayHelper::map(MasterKabupaten::find()->all(), 'nama_kabupaten', 'nama_kabupaten'),
                    'dataset' => ['limit' => 2],
                    'scrollable' => true,
                    'pluginOptions' => 
                    [
                        'highlight'=>true,
                        'allowClear' => true,
                        'multiple'=>true,
                    ],
                ]) 
            ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'KOTA_TUJUAN')->widget(TypeaheadBasic::classname(), [
                    'data' => ArrayHelper::map(MasterKabupaten::find()->all(), 'nama_kabupaten', 'nama_kabupaten'),
                    'dataset' => ['limit' => 2],
                    'scrollable' => true,
                    'pluginOptions' => 
                    [
                        'highlight'=>true,
                        'allowClear' => true,
                        'multiple'=>true,
                    ],
                ]) 
            ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'INSTANSI_TUJUAN')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-12">
            <hr/>
        </div>
        <div class="col-md-12"> <i>Detail SPPD</i></div>
        <div class="col-md-12">
            <?= $form->field($model, 'URAIAN_TUGAS')->textarea(['rows' => 5]) ?>
        </div>
        <div class="col-md-12">
            <hr/>
        </div>
    </div>

    <div class="row" style="margin-right: 0px;">
        <div class="col-md-12">
            <?= $form->field($model, 'STATUS_PENGAJUAN')->hiddenInput()->label(false) ?>
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
