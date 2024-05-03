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

$this->title = 'Data Pengajuan Perjalanan Dinas';
$this->params['breadcrumbs'][] = $this->title;

$queryWhere = ['OR',['STATUS_PENGAJUAN'=> "1"],['STATUS_PENGAJUAN'=> "2"]];
if(Yii::$app->user->identity->JENIS == "13"):
    $queryWhere = ['STATUS_PENGAJUAN'=>'1','MSB'=>Yii::$app->user->identity->UNIT];
elseif(Yii::$app->user->identity->JENIS == "14"):
    $queryWhere = ['STATUS_PENGAJUAN'=>'2'];
endif;

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

Modal::begin([
    'id'=>'rejected',
    'size'=>'modal-md',
    'header'=>'<h5 id="header-rejected">Confirmation</h5>',
    'headerOptions' => ['class'=>'danger-modal'],
    ]);
echo $this->render('rejected', [
    'model' => new PlnESppd(),
]);
Modal::end(); 

$this->registerJs(
    "$('#rejected').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var key = button.data('key');
        $('#plnesppd-id').attr('value',key);
    })"
);

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
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{update} {update-rej}',
        'visible'=> (Yii::$app->user->identity->JENIS == "13" OR Yii::$app->user->identity->JENIS == "14"),
        'noWrap'=>true,
        'buttons'=> [
            //view button
            'update' => function ($url, $model,$key) {
                if($model->STATUS_PENGAJUAN == "1"):
                    $text = "rekomendasikan";
                    $url = $url.'&key=2';
                elseif($model->STATUS_PENGAJUAN == "2"):
                    $text = "menyetujui";
                    $url = $url.'&key=3';
                endif;
                return Html::a(
                    '<i class="glyphicon glyphicon-ok"></i>',
                    $url,
                    [
                        'data-confirm' => 'Anda ingin '.$text.' data perjalanan dinas ini?',
                        'data-method'=>'post',
                        'type'=>'button',
                        'title'=>$text, 
                    ]
                );
            },
            'update-rej' => function ($url, $model,$key) {
                return Html::a(
                    '<i class="glyphicon glyphicon-remove"></i>',
                    $url,
                    [
                        'type'=>'button',
                        'title'=>Yii::t('app', 'Tolak'), 
                        'data-toggle'=>'modal',
                        'data-key'=>$key,
                        'data-target'=>'#rejected'
                    ]);
            },
        ]
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
        'filter'=> ArrayHelper::map(PlnESppd::find()->select('CHARGE_CODE')->andWhere($queryWhere)->groupBy(['CHARGE_CODE'])->asArray()->all(), 'CHARGE_CODE', 'CHARGE_CODE'),
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
        'filter'=> ArrayHelper::map(PlnESppd::find()->select('ID')->andWhere($queryWhere)->groupBy(['ID'])->asArray()->all(), 'ID', 'ID'),
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
        'filter'=> ArrayHelper::map(PlnESppd::find()->select('NO_INDUK')->andWhere($queryWhere)->groupBy(['NO_INDUK'])->asArray()->all(), 'NO_INDUK', 'NO_INDUK'),
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
        'filter'=> ArrayHelper::map(PlnESppd::find()->select('NAMA')->andWhere($queryWhere)->groupBy(['NAMA'])->asArray()->all(), 'NAMA', 'NAMA'),
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
        'filter'=> ArrayHelper::map(PlnESppd::find()->select('JABATAN')->andWhere($queryWhere)->groupBy(['JABATAN'])->asArray()->all(), 'JABATAN', 'JABATAN'),
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
        'filter'=> ArrayHelper::map(PlnESppd::find()->select('JENIS_TRANPORTASI')->andWhere($queryWhere)->groupBy(['JENIS_TRANPORTASI'])->asArray()->all(), 'JENIS_TRANPORTASI', 'JENIS_TRANPORTASI'),
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
            'exportFormView' => '_form',
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
            // (Yii::$app->user->identity->JENIS == "2") ? Html::button('<span class="glyphicon glyphicon-ok"></span> Approval-All', ['class' => 'btn btn-info','id'=>'appAllSppd','data-pjax'=>0]) : '',
            // Html::a('<span class="glyphicon glyphicon-repeat"></span>', ['index-app'], ['class' => 'btn btn-default']),
            [
                'content'=> $ExportMenu
            ],
            '{toggleData}'
        ],
        'columns' => $columns,
    ]); ?>
</div>