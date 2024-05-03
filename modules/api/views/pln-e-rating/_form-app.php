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
use kartik\widgets\StarRating;
use dmstr\widgets\Alert;
use app\models\DVal;
use app\models\PlnERegion;

/* @var $this yii\web\View */
/* @var $model app\models\DataPengajuanSppd */

$this->title = Yii::t('app', 'Form Pengajuan {modelClass}: ', [
    'modelClass' => 'No. SPPD',
]) . $model->ID;

$styleLokal = "display:none";
$styleInter = "display:none";
if($model->JENIS_SPPD === "BIASA" OR $model->JENIS_SPPD === "KONSINYERING"): 
    $styleLokal = "display:blok";
endif;
if($model->JENIS_SPPD === "INTERNASIONAL"): 
    $styleInter = "display:blok";
endif;

?>
<?= Alert::widget() ?>

<div class="form-box container">
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
            <?= $form->field($model, 'JENIS_SPPD')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(DVal::find()->andWhere(['key' => 'JENIS_SPPD'])->andWhere(['TABLE'=>'pln_e_sppd'])->asArray()->all(), 'KEY', 'VALUE'),
                'pluginOptions' => [
                    'allowClear' => false
                ],
                ])
            ?>
        </div>
        <div class="col-md-12" id="is_lumpsum-form" style=<?=$styleLokal?> >
            <?= $form->field($model, 'IS_LUMPSUM')->checkbox() ?>
        </div>
        <div class="col-md-12" id="wil_lokal-form" style=<?=$styleLokal?> >
            <?= $form->field($model, 'WIL_LOKAL')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(DVal::find()->andWhere(['key' => 'WILAYAH'])->andWhere(['TABLE'=>'pln_e_sppd'])->asArray()->all(), 'KEY', 'VALUE'),
                'pluginOptions' => [
                    'allowClear' => false
                ],
                ]) 
            ?>
        </div>
        <div class="col-md-12" id="jenis_tranportasi-form" style=<?=$styleLokal?> >
            <?= $form->field($model, 'JENIS_TRANPORTASI')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(DVal::find()->andWhere(['key' => 'JENIS_TRANPORTASI'])->andWhere(['TABLE'=>'pln_e_sppd'])->asArray()->all(), 'KEY', 'VALUE'),
                'pluginOptions' => [
                    'allowClear' => false
                ],
                ]) 
            ?>
        </div>
        <div class="col-md-12" id="wil_inter-form" style=<?=$styleInter?> >
            <?= $form->field($model, 'WIL_INTER')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(PlnERegion::find()->asArray()->all(), 'ID', 'REGION'),
                'pluginOptions' => [
                    'allowClear' => false
                ],
                ]) 
            ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'ASAL')->widget(TypeaheadBasic::classname(), [
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
            <?= $form->field($model, 'TUJUAN')->widget(TypeaheadBasic::classname(), [
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
            <?= $form->field($model, 'RATING')->widget(StarRating::classname(), [
                'pluginOptions' => [
                    'step' => 0.5,
                    'starCaptions' => false,
                    'showClear' => false,
                ]
            ]) ?>
        </div>
        <div class="col-md-12">
            <hr/>
        </div>
    </div>

    <div class="row" style="margin-right: 0px;">
        <div class="col-md-12">
            <?=
                Html::submitButton('<span class="glyphicon glyphicon-ok"></span>'. Yii::t('app', ' Submit'), ['class' => 'btn btn-sm btn-primary'])
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
