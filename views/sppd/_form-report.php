<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\daterange\DateRangePicker;
use app\models\Pegawai;

/* @var $this yii\web\View */
/* @var $model app\models\KsoPayrollSearch */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="sppd-serach box box-primary" style="overflow-x: hidden; padding:10px;">

    <h4><?=$this->title?></h4>

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_VERTICAL,
        // 'action'=>$model->isNewRecord ? ['admin/create'] : ['admin/update','id'=>$model->ID],
        'method' => 'post',
        'options'=>['id' =>  $id.'-report-form','enableAjaxValidation'=>true]
    ]); ?>

    <?= $form->field($searchModel, 'TGL_PENGAJUAN',['options' => ['class' => 'form-group col-md-6']])->widget(DateRangePicker::classname(), [
            'presetDropdown'=>false,
            'convertFormat'=>true,
            'includeMonthsFilter'=>true,
            'pluginOptions' => [
                'locale' => ['format' => 'Y-m-d'],
                
            ],
            'options' => [
                'placeholder' => 'Pilih Periode',
                'id' => 'TGL_PENGAJUAN-'.$id
            ]
        ]); 
    ?>

    <?= $form->field($searchModel, 'PENEMPATAN',['options' => ['class' => 'form-group col-md-6']])->widget(Select2::classname(), [
            'data' =>  ArrayHelper::map(Pegawai::find()->rightJoin('kode_aktif', 'kode_aktif.KD_AKTIF = pegawai.KD_AKTIF AND kode_aktif.KETERANGAN = "A"')->rightJoin('data_spk', 'data_spk.ID_DATA_SPK = pegawai.ID_DATA_SPK AND data_spk.APP = "JATENG"')->andWhere(['dbsimponi.pegawai.STATUS_APPROVAL' => '1'])->groupBy('dbsimponi.pegawai.PENEMPATAN')->all(), 'PENEMPATAN', 'PENEMPATAN'),
            'options' => [
                'placeholder' => 'Pilih Penempatan ...',
                'id' => 'PENEMPATAN-'.$id
            ],
            'pluginOptions' => ['allowClear' => false],
        ])
    ?>
    <?= $form->field($searchModel, 'NOMOR_SURAT',['options' => ['class' => 'form-group col-md-6']])->textInput(['maxlength' => true]) ?>
    <?= $form->field($searchModel, 'PERIHAL',['options' => ['class' => 'form-group col-md-6']])->textInput(['maxlength' => true]) ?>
    <?= $form->field($searchModel, 'NAMA_MANAGER_CABANG',['options' => ['class' => 'form-group col-md-6']])->textInput(['maxlength' => true]) ?>
    <?= $form->field($searchModel, 'NAMA_USER',['options' => ['class' => 'form-group col-md-6']])->textInput(['maxlength' => true]) ?>

    <div class="form-group col-md-12">
        <?= Html::submitButton('<span class="glyphicon glyphicon-print"></span> Print', ['class' => 'btn btn-success','name'=>$id,'value'=>$id]) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <br/>

</div>
