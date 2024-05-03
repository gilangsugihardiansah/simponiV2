<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use kartik\widgets\FileInput;
use yii\helpers\ArrayHelper;
use kartik\widgets\StarRating;
use app\models\DVal;
use app\models\PlnESppd;
use yii\helpers\Url; 

/* @var $this yii\web\View */
/* @var $searchModel app\models\PayrollSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Perjalanan Dinas';
$this->params['breadcrumbs'][] = $this->title;

Modal::begin([
    'id'=>'modalfiledownload',
    'size'=>'modal-xs',
    'options' => ['tabindex' => false ],
    'header'=>Html::a('<span class="glyphicon glyphicon-download"></span>'.' Download', ['#'], ['class' => 'btn btn-primary','data-pjax'=> 0,'title' => 'Download file','id'=>'urlmodaldownload', 'target' => '_blank']),
    'headerOptions' => ['class'=>'default-modal'],
    'bodyOptions' => ['class'=>'modal-body body-file'],
    ]);
echo '<embed src="#" frameborder="1" style="width:100%;min-height:500px;" id="imgmodaldownload">';
echo '<hr/><div class="pull-right hidden-xs"><b>Version</b> 1.0</div><strong>Copyright &copy; 2019 <a href="http://www.hapindo.co.id/index.php">PT. Haleyora Powerindo</a>.</strong> All rights reserved.';
Modal::end(); 

$columns = 
[
    [
        'class'=>'kartik\grid\SerialColumn',
        'contentOptions'=>['class'=>'kartik-sheet-style'],
        'width'=>'36px',
        'header'=>'',
        'headerOptions'=>['class'=>'kartik-sheet-style']
    ],
    [
        'class'=>'kartik\grid\ExpandRowColumn',
        'expandTitle'=>'Detail Perjalanan Dinas',
        'value'=>function($model,$key,$index,$column) { return GridView::ROW_COLLAPSED;},
        'expandOneOnly'=>true,
        'detailUrl' => Url::to(['/pln-e-sppd/view']),
    ],
    [
        'attribute'=>'STATUS_PENGAJUAN',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=> ArrayHelper::map(DVal::find()->andWhere(['DESCRIPTION'=>'STATUS_PENGAJUAN'])->andWhere(['TABLE'=>'pln_e_sppd'])->all(), 'KEY', 'VALUE'),
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'','id'=>'sppd-STATUS_PENGAJUAN'],
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
        'attribute'=>'CREATED_AT',
        'filterType'=>GridView::FILTER_DATE_RANGE,
        'filterWidgetOptions' => [
            'model' => $searchModel,
            'presetDropdown' => true,
            'convertFormat' => true,
            'pluginOptions'=>[
                'locale' => [
                    'format' => 'Y-m-d',
                ],
                'opens'=>'right',
                'todayHighlight' => true,
            ],
        ],
        'hAlign'=>'center',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>false,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'CHARGE_CODE',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=> ArrayHelper::map(PlnESppd::find()->select('CHARGE_CODE')->groupBy(['CHARGE_CODE'])->asArray()->all(), 'CHARGE_CODE', 'CHARGE_CODE'),
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'','id'=>'sppd_pln_e-CHARGE_CODE'],
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'ID',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=> ArrayHelper::map(PlnESppd::find()->select('ID')->groupBy(['ID'])->asArray()->all(), 'ID', 'ID'),
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'','id'=>'sppd_pln_e-ID'],
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'NO_INDUK',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=> ArrayHelper::map(PlnESppd::find()->select('NO_INDUK')->groupBy(['NO_INDUK'])->asArray()->all(), 'NO_INDUK', 'NO_INDUK'),
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'','id'=>'sppd_pln_e-NO_INDUK'],
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'NAMA',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=> ArrayHelper::map(PlnESppd::find()->select('NAMA')->groupBy(['NAMA'])->asArray()->all(), 'NAMA', 'NAMA'),
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'','id'=>'sppd_pln_e-NAMA'],
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>false,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'JABATAN',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=> ArrayHelper::map(PlnESppd::find()->select('JABATAN')->groupBy(['JABATAN'])->asArray()->all(), 'JABATAN', 'JABATAN'),
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'','id'=>'sppd_pln_e-JABATAN'],
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>false,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'JENIS_SPPD',
        'value'=>'jenis.VALUE',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=> ArrayHelper::map(DVal::find()->andWhere(['DESCRIPTION'=>'JENIS_SPPD'])->andWhere(['TABLE'=>'pln_e_sppd'])->all(), 'KEY', 'VALUE'),
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'','id'=>'sppd-JENIS_SPPD'],
        'noWrap'=>false,
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
    ], 
    [
        'attribute'=>'TGL_BERANGKAT',
        'filterType'=>GridView::FILTER_DATE_RANGE,
        'filterWidgetOptions' => [
            'model' => $searchModel,
            'presetDropdown' => true,
            'convertFormat' => true,
            'pluginOptions'=>[
                'locale' => [
                    'format' => 'Y-m-d',
                ],
                'opens'=>'right',
                'todayHighlight' => true,
            ],
        ],
        'hAlign'=>'center',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'TGL_KEMBALI',
        'filterType'=>GridView::FILTER_DATE_RANGE,
        'filterWidgetOptions' => [
            'model' => $searchModel,
            'presetDropdown' => true,
            'convertFormat' => true,
            'pluginOptions'=>[
                'locale' => [
                    'format' => 'Y-m-d',
                ],
                'opens'=>'right',
                'todayHighlight' => true,
            ],
        ],
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
        'noWrap'=>false,
        // 'pageSummary'=>true,
    ],
    [
        'class' => 'kartik\grid\BooleanColumn',
        'attribute'=>'IS_LUMPSUM',
        'trueLabel' => 'Ya',
        'falseLabel' => 'Tidak',
        'falseIcon' => '<h6 class="text-danger">Tidak</h6>',
        'trueIcon' => '<h6 class="text-primary">Ya</h6>', 
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'options' => ['placeholder'=>'Select...'],
            'pluginOptions' => [
                'allowClear' => true
            ],                    
        ], 
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
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=> ArrayHelper::map(PlnESppd::find()->select('JENIS_TRANPORTASI')->groupBy(['JENIS_TRANPORTASI'])->asArray()->all(), 'JENIS_TRANPORTASI', 'JENIS_TRANPORTASI'),
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'','id'=>'sppd_pln_e-JENIS_TRANPORTASI'],
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'RATING',
        'value'=>function($model){
            return StarRating::widget([
                'model' => $model, 
                'name'=>'RATING',
                'value'=>$model->RATING,
                'pluginOptions' => [
                    'displayOnly' => true,
                    'size' => 'sm',
                    'min' => 0,
                    'max' => 5,
                    'step' => 0.5,
                    'starCaptions' => [
                        0 => 'Belum DInilai',
                        1 => 'Sangat Tidak Memuaskan',
                        2 => 'Tidak Memuaskan',
                        3 => 'Cukup Memuaskan',
                        4 => 'Memuaskan',
                        5 => 'Sangat Memuaskan',
                        // 12 => 'Extremely Good',
                    ],
                    'starCaptionClasses' => [
                        0 => 'text-danger',
                        1 => 'text-danger',
                        2 => 'text-warning',
                        3 => 'text-info',
                        4 => 'text-primary',
                        5 => 'text-success',
                        // 12 => 'text-success'
                    ],
                ]
            ]);
        },
        'mergeHeader'=>true,
        'format'=>'raw',
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
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
    [
        'attribute'=>'ALASAN',
        'mergeHeader'=>true,
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'UPDATED_AT',
        'filterType'=>GridView::FILTER_DATE_RANGE,
        'filterWidgetOptions' => [
            'model' => $searchModel,
            'presetDropdown' => true,
            'convertFormat' => true,
            'pluginOptions'=>[
                'locale' => [
                    'format' => 'Y-m-d',
                ],
                'opens'=>'right',
                'todayHighlight' => true,
            ],
        ],
        'hAlign'=>'center',
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
