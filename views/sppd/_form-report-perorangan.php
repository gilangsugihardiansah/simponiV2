<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use app\models\Pegawai;

/* @var $this yii\web\View */
/* @var $model app\models\KsoPayrollSearch */
/* @var $form yii\widgets\ActiveForm */
$searchModel->PENEMPATAN=Yii::$app->user->identity->UNIT;
if(Yii::$app->user->identity->JENIS=='3'){
    $style="display:none;";
    $class='form-group col-md-12';
}else{
    $style='';
    $class='form-group col-md-6';
}

?>

<div class="sppd-serach box box-primary" style="overflow-x: hidden; padding:10px;">

    <h4>Data Rekap Penagihan</h4>

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_VERTICAL,
        // 'action'=>$model->isNewRecord ? ['admin/create'] : ['admin/update','id'=>$model->ID],
        'method' => 'post',
        'options'=>['id' =>  $id.'-report-form-perorang','enableAjaxValidation'=>true]
    ]); ?>

    <?= $form->field($searchModel, 'PERIODE',['options' => ['class' => $class]])->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Periode','id'=>'orang',],
                    
                    // 'attribute2'=>'to_date',
                    'type' => DatePicker::TYPE_INPUT,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'startView'=>'year',
                        'minViewMode'=>'months',
                        'format' => 'yyyy-mm'
                    ]
                ])
    ?>
    <div style=<?=$style?>>
        <?= $form->field($searchModel, 'PENEMPATAN',['options' => ['class' => 'form-group col-md-6']])->widget(Select2::classname(), [
                'data' =>  ArrayHelper::map(Pegawai::find()->rightJoin('kode_aktif', 'kode_aktif.KD_AKTIF = pegawai.KD_AKTIF AND kode_aktif.KETERANGAN = "A"')->rightJoin('data_spk', 'data_spk.ID_DATA_SPK = pegawai.ID_DATA_SPK AND data_spk.APP = "JATENG"')->andWhere(['dbsimponi.pegawai.STATUS_APPROVAL' => '1'])->groupBy('dbsimponi.pegawai.PENEMPATAN')->all(), 'PENEMPATAN', 'PENEMPATAN'),
                
                'options' => [
                    'placeholder' => 'Pilih Penempatan ...',
                    'id' => 'PENEMPATAN-'.$id,
                    // 'visible'=>false,
                ],
                'pluginOptions' => ['allowClear' => false,],
            ])
        ?>
</div>

    
    
    <div class="form-group col-md-12">
        <?= Html::submitButton('<span class="glyphicon glyphicon-print"></span> Print', ['class' => 'btn btn-success','name'=>$id,'value'=>$id]) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <br/>

</div>
