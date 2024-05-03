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
use app\models\PlnERegion;
use kartik\depdrop\DepDrop;
use kartik\widgets\SwitchInput;

/* @var $this yii\web\View */
/* @var $model app\models\DataPengajuanSppd */

if($model->STATUS_PENGAJUAN == "3"):
    $model->scenario = "setujui";
endif;

$styleLokal = "display:none";
$styleInter = "display:none";
$styleWilLokal = "display:none";
if($model->JENIS_SPPD === "BIASA" OR $model->JENIS_SPPD === "KONSINYERING"): 
    $styleLokal = "display:blok";
    if($model->IS_LUMPSUM === 1): 
        $styleWilLokal = "display:blok";
    endif;
endif;
if($model->JENIS_SPPD === "INTERNASIONAL"): 
    $styleInter = "display:blok";
endif;

// print_r(PlnERegion::find()->asArray()->all());die;


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
                    'data' => ArrayHelper::map(DVal::find()->andWhere(['DESCRIPTION' => 'JENIS_SPPD'])->andWhere(['TABLE'=>'pln_e_sppd'])->asArray()->all(), 'KEY', 'VALUE'),
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                    'options' => [
                        'id' => $model->isNewRecord ? 'create-JENIS-sppd' : 'update-JENIS-sppd',
                        'onchange' => '
                            if($(this).val() == "BIASA" || $(this).val() == "KONSINYERING") {
                                $("#is_lumpsum-form").show()
                                $("#plnesppd-is_lumpsum").prop("required",true)
                                $("#tujuan_lokal-form").show()
                                $("#plnesppd-tujuan_lokal").prop("required",true)
                                $("#plnesppd-is_lumpsum").prop("checked",false)
                                $("#plnesppd-is_lumpsum").bootstrapSwitch("state",false)
                                $("#wil_lokal-form").hide()
                                $("#plnesppd-wil_lokal").prop("required",false)
                                $("#jenis_tranportasi-form").show()
                                $("#plnesppd-jenis_tranportasi").prop("required",true)
                                $("#wil_inter-form").hide()
                                $("#plnesppd-wil_inter").prop("required",false)
                                $("#tujuan_inter-form").hide()
                                $("#plnesppd-tujuan_inter").prop("required",false)
                            } else if($(this).val() == "INTERNASIONAL") {
                                $("#wil_inter-form").show()
                                $("#plnesppd-wil_inter").prop("required",true)
                                $("#tujuan_inter-form").show()
                                $("#plnesppd-tujuan_inter").prop("required",true)
                                $("#plnesppd-is_lumpsum").prop("checked",false)
                                $("#plnesppd-is_lumpsum").bootstrapSwitch("state",false)
                                $("#is_lumpsum-form").hide()
                                $("#plnesppd-is_lumpsum").prop("required",false)
                                $("#jenis_tranportasi-form").hide()
                                $("#plnesppd-jenis_tranportasi").prop("required",false)
                                $("#wil_lokal-form").hide()
                                $("#plnesppd-wil_lokal").prop("required",false)
                                $("#tujuan_lokal-form").hide()
                                $("#plnesppd-tujuan_lokal").prop("required",false)
                            } else {
                                $("#plnesppd-is_lumpsum").prop("checked",false)
                                $("#bawahan-form").hide()
                                $("#wil_inter-form").hide()
                                $("#plnesppd-wil_inter").prop("required",false)
                                $("#is_lumpsum-form").hide()
                                $("#plnesppd-is_lumpsum").prop("required",false)
                                $("#plnesppd-is_lumpsum").bootstrapSwitch("state",false)
                                $("#jenis_tranportasi-form").hide()
                                $("#plnesppd-jenis_tranportasi").prop("required",false)
                                $("#wil_lokal-form").hide()
                                $("#plnesppd-wil_lokal").prop("required",false)
                                $("#tujuan_lokal-form").hide()
                                $("#plnesppd-tujuan_lokal").prop("required",false)
                                $("#tujuan_inter-form").hide()
                                $("#plnesppd-tujuan_inter").prop("required",false)
                            }
                        ',
                    ]
                ])
            ?>
        </div>
        <div class="col-md-12" id="is_lumpsum-form" style=<?=$styleLokal?> >
            <?= $form->field($model, 'IS_LUMPSUM')->widget(SwitchInput::classname(), [
                'pluginOptions' => [
                    'onText' => 'Yes',
                    'offText' => 'No',
                ],
                'options'=>[
                    'onChange'=>'
                        if($(this).bootstrapSwitch("state") == true){
                            $("#wil_lokal-form").show()
                            $("#plnesppd-wil_lokal").prop("required",true)
                        } else {
                            $("#wil_lokal-form").hide()
                            $("#plnesppd-wil_lokal").prop("required",false)
                        }
                    '
                ]
            ]);
            ?>
        </div>
        <div class="col-md-12" id="wil_lokal-form" style=<?=$styleWilLokal?> >
            <?= $form->field($model, 'WIL_LOKAL')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(DVal::find()->andWhere(['DESCRIPTION' => 'WILAYAH'])->andWhere(['TABLE'=>'pln_e_sppd'])->asArray()->all(), 'KEY', 'VALUE'),
                'pluginOptions' => [
                    'allowClear' => false
                ],
                ]) 
            ?>
        </div>
        <div class="col-md-12" id="jenis_tranportasi-form" style=<?=$styleLokal?> >
            <?= $form->field($model, 'JENIS_TRANPORTASI')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(DVal::find()->andWhere(['DESCRIPTION' => 'JENIS_TRANPORTASI'])->andWhere(['TABLE'=>'pln_e_sppd'])->asArray()->all(), 'KEY', 'VALUE'),
                'pluginOptions' => [
                    'allowClear' => false
                ],
                ]) 
            ?>
        </div>
        <div class="col-md-12" id="wil_inter-form" style=<?=$styleInter?> >

            <?= $form->field($model, 'WIL_INTER')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(PlnERegion::find()->select('ID,REGION')->groupBy('ID')->asArray()->all(), 'ID', 'REGION'),
                    'options' => ['placeholder' => '','id' => $model->isNewRecord ? 'create-ID_VP' : 'update-WIL_INTER'],
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
        <div class="col-md-12" id="tujuan_lokal-form" style=<?=$styleLokal?> >
            <?= $form->field($model, 'TUJUAN_LOKAL')->widget(TypeaheadBasic::classname(), [
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
        <div class="col-md-12" id="tujuan_inter-form" style=<?=$styleInter?> >
            <?= $form->field($model, 'TUJUAN_INTER')->widget(DepDrop::classname(), [
                    'options' => ['placeholder' => 'Select ...'],
                    'type' => DepDrop::TYPE_SELECT2,
                    'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                    'pluginOptions' => [
                        'depends' => [
                            'update-WIL_INTER',
                        ],
                        'initialize' => true,
                        'url' => Url::to(['/pln-e-negara/child-account']),
                        'params' => ['WIL_INTER'],
                        'loadingText' => 'Select ...',
                    ]
                ])
            ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'INSTANSI_TUJUAN')->textInput(['maxlength' => true]) ?>
        </div>
        <?php if($model->STATUS_PENGAJUAN == "3" && $model->JENIS_SPPD === "INTERNASIONAL"):?>
            <div class="col-md-12">
            <?= $form->field($model, 'KURS_DOLAR')->textInput(['maxlength' => true]) ?>
            </div>
        <?php endif; ?>
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
        // document.addEventListener("contextmenu", function(e){
        //     e.preventDefault();
        // }, false);
        // document.onkeydown = function(e) {
        //     if(event.keyCode == 123) {
        //         return false;
        //     }
        //     if(e.ctrlKey && e.shiftKey && e.keyCode == "I".charCodeAt(0)){
        //         return false;
        //     }
        //     if(e.ctrlKey && e.shiftKey && e.keyCode == "J".charCodeAt(0)){
        //         return false;
        //     }
        //     if(e.ctrlKey && e.keyCode == "U".charCodeAt(0)){
        //         return false;
        //     }
        // };
    ');
?>
