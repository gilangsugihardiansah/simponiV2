<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\daterange\DateRangePicker;
use app\models\Pegawai;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\KsoPayrollSearch */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Data Rekap Perjalanan Dinas';
$this->params['breadcrumbs'][] = $this->title;

Modal::begin([
    'id'=>'excel',
    'options' => ['tabindex' => false ],
    'size'=>'modal-md',
    'header' => $this->title,
    'headerOptions' => ['class'=>'modal-header'],
    'bodyOptions' => ['class'=>'modal-body bg-white body-excel'],
    ]);
echo $this->render('_form-report', [
    'searchModel' => $searchModel,
    'dataProvider' => $dataProvider,
    'tglAwal'=>$tglAwal,
    'tglAkhir'=>$tglAkhir,
    'id'=>'excel'
]);
Modal::end(); 

Modal::begin([
    'id'=>'excel-penagihan',
    'options' => ['tabindex' => false ],
    'size'=>'modal-md',
    'header' => 'Data Rekap Penagihan',
    'headerOptions' => ['class'=>'modal-header'],
    'bodyOptions' => ['class'=>'modal-body bg-white body-excel'],
    ]);
echo $this->render('_form-report-penagihan', [
    'searchModel' => $searchModel,
    'dataProvider' => $dataProvider,
    'tglAwal'=>$tglAwal,
    'tglAkhir'=>$tglAkhir,
    'id'=>'excel-penagihan'
]);
Modal::end(); 

Modal::begin([
    'id'=>'pdf',
    'options' => ['tabindex' => false ],
    'size'=>'modal-md',
    'header' => $this->title,
    'headerOptions' => ['class'=>'modal-header'],
    'bodyOptions' => ['class'=>'modal-body bg-white body-pdf'],
    ]);
echo $this->render('_form-report', [
    'searchModel' => $searchModel,
    'dataProvider' => $dataProvider,
    'tglAwal'=>$tglAwal,
    'tglAkhir'=>$tglAkhir,
    'id'=>'pdf'
]);
Modal::end(); 

Modal::begin([
    'id'=>'excel-perorang',
    'options' => ['tabindex' => false ],
    'size'=>'modal-md',
    'header' => 'Data Rekap Detail Penagihan',
    'headerOptions' => ['class'=>'modal-header'],
    'bodyOptions' => ['class'=>'modal-body bg-white body-excel'],
    ]);
echo $this->render('_form-report-perorangan', [
    'searchModel' => $searchModel,
    'dataProvider' => $dataProvider,
    'tglAwal'=>$tglAwal,
    'tglAkhir'=>$tglAkhir,
    'id'=>'excel-perorang'
]);
Modal::end(); 

$style='';
if(Yii::$app->user->identity->JENIS == "3"){
    $style="display:none;";
}

?>

<div class="sppd-serach box box-primary" style="overflow-x: hidden; padding:10px;<?=$style?>">

    <h4><?=$this->title?></h4>

    <div class="form-group">
        <?= Html::a('<span class="glyphicon glyphicon-print"></span> Print Excel', ['#'], ['class' => 'btn btn-primary','data-toggle'=>'modal','data-target'=>'#excel']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-print"></span> Print PDF', ['#'], ['class' => 'btn btn-danger','data-toggle'=>'modal','data-target'=>'#pdf']) ?>
    </div>

</div>

<div class="sppd-serach box box-primary" style="overflow-x: hidden; padding:10px;">

    <h4>Data Rekap Penagihan</h4>

    <div class="form-group">
        <?= Html::a('<span class="glyphicon glyphicon-print"></span> Print Excel', ['#'], ['class' => 'btn btn-primary','data-toggle'=>'modal','data-target'=>'#excel-penagihan']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-print"></span> Print Detail', ['#'], ['class' => 'btn btn-primary','data-toggle'=>'modal','data-target'=>'#excel-perorang']) ?>
    </div>

</div>
