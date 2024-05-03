<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use kartik\widgets\FileInput;
use yii\helpers\ArrayHelper;
use app\models\Pegawai;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PayrollSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tenaga Kerja';
$this->params['breadcrumbs'][] = $this->title;

$columns = 
[
    // [
    //     'class'=>'kartik\grid\ExpandRowColumn',
    //     'expandTitle'=>'Detail Pegawai',
    //     'value'=>function($model,$key,$index,$column) { return GridView::ROW_COLLAPSED;},
    //     'detail'=>function($model,$key,$index,$column) 
    //     {
    //         // if($model->TAHUN_BULAN != '2021.03'):
    //             return $this->render('detail', [
    //                 'model' => $model,
    //                 'key' => $key,
    //                 'index' => $index,
    //                 'bool' => false,
    //             ]);
    //         // endif;
    //     },
    // ],
    [
        'attribute'=>'NO_KTP',
        // 'mergeHeader'=>true,
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'NO_INDUK',
        // 'mergeHeader'=>true,
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'NAMA',
        // 'mergeHeader'=>true,
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'NO_SPK',
        // 'filterType'=>GridView::FILTER_SELECT2,
        // 'filter'=> ArrayHelper::map(Pegawai::find()->rightJoin('kode_aktif', 'kode_aktif.KD_AKTIF = pegawai.KD_AKTIF AND kode_aktif.KETERANGAN = "A"')->rightJoin('data_spk', 'data_spk.ID_DATA_SPK = pegawai.ID_DATA_SPK AND (data_spk.APP = "ASTRO" OR data_spk.APP = "JATENG" OR data_spk.APP = "HP")')->andWhere(['dbsimponi.pegawai.STATUS_APPROVAL' => '1'])->groupBy('dbsimponi.data_spk.NO_SPK')->all(), 'spkku.NO_SPK', 'spkku.NO_SPK'),
        // 'filterWidgetOptions'=>[
        //     'pluginOptions'=>['allowClear'=>true],
        // ],
        // 'filterInputOptions'=>['placeholder'=>'','id'=>'peg-NO_SPK'],
        'value'=>'spkku.NO_SPK',
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'JABATAN',
        'value'=>'spkku.JABATAN',
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'PEKERJAAN',
        'value'=>'spkku.PEKERJAAN',
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'PENEMPATAN',
        // 'filterType'=>GridView::FILTER_SELECT2,
        // 'filter'=> ArrayHelper::map(Pegawai::find()->rightJoin('kode_aktif', 'kode_aktif.KD_AKTIF = pegawai.KD_AKTIF AND kode_aktif.KETERANGAN = "A"')->rightJoin('data_spk', 'data_spk.ID_DATA_SPK = pegawai.ID_DATA_SPK AND data_spk.APP = "JATENG"')->andWhere(['dbsimponi.pegawai.STATUS_APPROVAL' => '1'])->groupBy('dbsimponi.pegawai.PENEMPATAN')->all(), 'PENEMPATAN', 'PENEMPATAN'),
        // 'filterWidgetOptions'=>[
        //     'pluginOptions'=>['allowClear'=>true],
        // ],
        // 'filterInputOptions'=>['placeholder'=>'','id'=>'peg-DIVISI'],
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'KELAMIN',
        'value'=>'klm',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=> ['1'=>'Pria','2'=>'Wanita'],
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'','id'=>'peg-KELAMIN'],
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'KAWIN',
        'value'=>'kwn',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=> ['1'=>'Lajang','2'=>'Kawin','3'=>'Duda/Janda'],
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'','id'=>'peg-KAWIN'],
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'AGAMA',
        'value'=>'agm',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=> ['1'=>'Islam','2'=>'Kristen','3'=>'Katolik','4'=>'Hindu','5'=>'Budha','6'=>'Kepercayaan'],
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'','id'=>'peg-AGAMA'],
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
];

        $ExportMenu = ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns'=> $columns,
            'exportConfig' => [
                ExportMenu::FORMAT_TEXT => false,
                ExportMenu::FORMAT_HTML => false,
                ExportMenu::FORMAT_EXCEL_X  => [
                    'showHeader' => true,
                    'showPageSummary' => true,
                    'showFooter' => true,
                ],
            ],
            'showConfirmAlert'=>false,
            'pjaxContainerId' => 'setfont-pjax',
            'target'=>ExportMenu::TARGET_BLANK,
            'filename'=>'Export '.Html::encode($this->title), 
            'dropdownOptions' => [
                'class' => 'btn btn-default',
                'itemsBefore' => [
                    '<li class="dropdown-header">Export All Data</li>',
                ],
            ],
        ]);

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
            [
                'content'=> $ExportMenu
            ],
            '{toggleData}'
        ],
        'columns' => $columns,
    ]); ?>
</div>