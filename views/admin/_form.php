<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\export\ExportMenu;
use kartik\widgets\DatePicker;
use kartik\widgets\FileInput;
use app\models\JenisUser;
use app\models\Pegawai;
use app\models\PlnEMsb;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Payroll */
/* @var $form yii\widgets\ActiveForm */

$styleUnit = "display:none";
$styleBawahan = "display:none";
$styleMsb = "display:none";

if($model->JENIS == "3" OR $model->JENIS == "10" OR $model->JENIS == "11"): 
    $styleUnit = "display:blok";
endif;
if($model->JENIS == "7" OR $model->JENIS == "8"): 
    $styleBawahan = "display:blok";
endif;
if($model->JENIS == "13"): 
    $styleMsb = "display:blok";
endif;
?>

<div class="sppd-form">

    <?php $form = ActiveForm::begin([
        'type'=>ActiveForm::TYPE_VERTICAL, 
        'formConfig'=>['labelSpan'=>4],
        'action'=>$model->isNewRecord ? ['admin/create'] : ['admin/update','id'=>$model->ID],
        'options'=>['id' =>  'upload-payroll-form','enableAjaxValidation'=>true,'enctype'=>'multipart/form-data']
    ]); ?>
    <?= $form->field($model, 'USERNAME')->textInput(['maxlength' => true]) ?>
    
    <?php if($model->isNewRecord): ?>
        <?= $form->field($model, 'PASSWORD')->passwordInput(['maxlength' => true]) ?>
    <?php endif; ?>

    <?= $form->field($model, 'NAMA')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'JENIS')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(JenisUser::find()->all(), 'ID', 'JENIS_USER'),
        'pluginOptions' => [
            'allowClear' => false
        ],
        'options' => [
            'id' => $model->isNewRecord ? 'create-JENIS-admin' : 'update-JENIS-admin',
            'onchange' => '
                if($(this).val() == "3"){
                    $.post("/web/unit-pln/get-unit.html?id=JATENG",function(data){
                        $("select#admin-unit").html( data )
                    });
                    $("#unit-form").show()
                    $("#admin-unit").prop("required",true)
                    $("#bawahan-form").hide()
                    $("#admin-data_bawahan").prop("required",false)
                } else if($(this).val() == "10" || $(this).val() == "11") {
                    $.post("/web/unit-pln/get-unit.html?id=PUSHARLIS",function(data){
                        $("select#admin-unit").html( data )
                    });
                    $("#unit-form").show()
                    $("#admin-unit").prop("required",true)
                    $("#bawahan-form").hide()
                    $("#admin-data_bawahan").prop("required",false)
                    $("#msb-form").hide()
                    $("#admin-data_msb").prop("required",false)
                } else if($(this).val() == "7" || $(this).val() == "8") {
                    $("#bawahan-form").show()
                    $("#admin-data_bawahan").prop("required",true)
                    $("#unit-form").hide()
                    $("#admin-unit").prop("required",false)
                    $("#msb-form").hide()
                    $("#admin-data_msb").prop("required",false)
                } else if($(this).val() == "13") {
                    $("#msb-form").show()
                    $("#admin-data_msb").prop("required",true)
                    $("#bawahan-form").hide()
                    $("#admin-data_bawahan").prop("required",false)
                    $("#unit-form").hide()
                    $("#admin-unit").prop("required",false)
                } else {
                    $("#bawahan-form").hide()
                    $("#admin-data_bawahan").prop("required",false)
                    $("#unit-form").hide()
                    $("#admin-unit").prop("required",false)
                    $("#msb-form").hide()
                    $("#admin-data_msb").prop("required",false)
                }
            ',
        ]
        ]) 
    ?>
    <div id="unit-form" style=<?=$styleUnit?> >
        <?= $form->field($model, 'UNIT')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(Pegawai::find()->select('pegawai.PENEMPATAN AS PENEMPATAN')->rightJoin('kode_aktif', 'kode_aktif.KD_AKTIF = pegawai.KD_AKTIF AND kode_aktif.KETERANGAN = "A"')->rightJoin('data_spk', 'data_spk.ID_DATA_SPK = pegawai.ID_DATA_SPK AND (data_spk.APP = "JATENG" OR data_spk.APP = "PUSHARLIS")')->andWhere(['dbsimponi.pegawai.STATUS_APPROVAL' => '1'])->groupBy('dbsimponi.pegawai.PENEMPATAN')->all(), 'PENEMPATAN', 'PENEMPATAN'),
            'pluginOptions' => [
                'allowClear' => false
            ],
            ]) 
        ?>
    </div>

    <div id="bawahan-form" style=<?=$styleBawahan?> >
        <?= $form->field($model, 'DATA_BAWAHAN')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(Pegawai::find()->select('pegawai.NO_INDUK AS NO_INDUK, pegawai.NAMA AS NAMA, data_spk.PEKERJAAN AS PEKERJAAN')->rightJoin('kode_aktif', 'kode_aktif.KD_AKTIF = pegawai.KD_AKTIF AND kode_aktif.KETERANGAN = "A"')->rightJoin('data_spk', 'data_spk.ID_DATA_SPK = pegawai.ID_DATA_SPK AND data_spk.APP = "HP"')->andWhere(['dbsimponi.pegawai.STATUS_APPROVAL' => '1'])->groupBy('dbsimponi.pegawai.NO_INDUK')->all(), 'NO_INDUK','NAMA','PEKERJAAN'),
            'pluginOptions' => [
                'allowClear' => false,
                'multiple' => true
            ],
            ]) 
        ?>
    </div>
    <div id="msb-form" style=<?=$styleMsb?> >
        <?= $form->field($model, 'MSB')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(PlnEMsb::find()->asArray()->all(), 'ID', 'NAMA'),
            'pluginOptions' => [
                'allowClear' => false
            ],
            ])->label('Bidang')
        ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-save"></span> Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
