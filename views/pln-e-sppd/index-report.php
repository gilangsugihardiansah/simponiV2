<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use kartik\widgets\FileInput;
use yii\helpers\ArrayHelper;
use app\models\DVal;
use app\models\PlnESppd;
use yii\helpers\Url; 

/* @var $this yii\web\View */
/* @var $searchModel app\models\PayrollSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rekap Data Perjalanan Dinas';
$this->params['breadcrumbs'][] = $this->title;

$queryWhere = ['STATUS_APP'=>1];
if(Yii::$app->user->identity->JENIS == "13"):
    $queryWhere = ['STATUS_PENGAJUAN'=>'1','MSB'=>Yii::$app->user->identity->UNIT];
elseif(Yii::$app->user->identity->JENIS == "14"):
    $queryWhere = ['STATUS_PENGAJUAN'=>'2'];
endif;

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
    'id'=>'excel'
]);
Modal::end(); 

$columns = 
[
    [
        'class'=>'kartik\grid\ExpandRowColumn',
        'expandTitle'=>'Detail Perjalanan Dinas',
        'value'=>function($model,$key,$index,$column) { return GridView::ROW_COLLAPSED;},
        'expandOneOnly'=>true,
        'detailUrl' => Url::to(['/pln-e-sppd/view']),
    ],
    [
        'attribute'=>'STATUS_PENGAJUAN',
        'mergeHeader'=>true,
        'value'=>function($model){
            return "<span class='badge' style='background-color: {$model->colors}'>{$model->status->VALUE}</span>";
        },
        'format'=>'HTML',
        'noWrap'=>true,
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
    ], 
    [
        'attribute'=>'UPDATED_AT',
        'mergeHeader'=>true,
        'hAlign'=>'center',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'CREATED_AT',
        'mergeHeader'=>true,
        'hAlign'=>'center',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'CHARGE_CODE',
        'mergeHeader'=>true,
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'ID',
        'mergeHeader'=>true,
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'NO_INDUK',
        'mergeHeader'=>true,
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'NAMA',
        'mergeHeader'=>true,
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'JABATAN',
        'mergeHeader'=>true,
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'JENIS_SPPD',
        'value'=>'jenis.VALUE',
        'mergeHeader'=>true,
        'noWrap'=>true,
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
    ], 
    [
        'attribute'=>'TGL_BERANGKAT',
        'mergeHeader'=>true,
        'hAlign'=>'center',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'TGL_KEMBALI',
        'mergeHeader'=>true,
        'hAlign'=>'center',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'JUMLAH_HARI',
        'mergeHeader'=>true,
        'hAlign'=>'center',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'class' => 'kartik\grid\BooleanColumn',
        'attribute'=>'IS_LUMPSUM',
        'trueLabel' => 'Ya',
        'falseLabel' => 'Tidak',
        'mergeHeader'=>true,
        'noWrap' => true,
        'hAlign'=>'center',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
    ],
    [
        'attribute'=>'WILAYAH',
        'value'=>'wil',
        'mergeHeader'=>true,
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
    ],
    [
        'attribute'=>'TUJUAN',
        'mergeHeader'=>true,
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'JENIS_TRANPORTASI',
        'mergeHeader'=>true,
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'EVIDENCE',
        'value'=>function($model){
            return Html::a('<span class="glyphicon glyphicon-picture">', '#',
                [
                    'type'=>'button',
                    'class'=>'btn btn-xs btn-info',
                    'data-toggle'=>'modal',
                    'data-target'=>'#modalfiledownload',
                    'data-whatever'=>empty($model->EVIDENCE) ? 'https://sppdonln.hapindo.co.id/web/file/no_image.png' : $model->EVIDENCE
                ]);
        },
        'mergeHeader'=>true,
        'format'=>'raw',
        'hAlign'=>'center',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
];

?>

    
<div class="payroll-index box box-primary" style="overflow-x: hidden;">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => 'setfont',
        'responsive' => true,
        'responsiveWrap' => false,
        'pjax'=>true,
        'hover'=>true,
        'condensed'=>true,
        'pjaxSettings' => ['options' => ['id' => 'setfont-pjax']],
        'headerRowOptions'=>['class'=>'kartik-sheet-style'],
        'filterRowOptions'=>['class'=>'kartik-sheet-style'],
        'persistResize'=>false,
        'showPageSummary'=>true,
        'panel'=>
        [
            'type'=>'default', 
            'heading'=>Html::encode($this->title),
        ],
        'toolbar' => 
        [
            Html::a('<span class="glyphicon glyphicon-export"></span> Export Rekap Excel', ['#'], ['class' => 'btn btn-default','data-toggle'=>'modal','data-target'=>'#excel']),
            '{toggleData}'
        ],
        'columns' => $columns,
    ]); ?>
</div>