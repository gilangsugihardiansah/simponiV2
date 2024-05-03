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

/* @var $this yii\web\View */
/* @var $searchModel app\models\PayrollSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Lembur';
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

Modal::begin([
    'id'=>'modalmap',
    'size'=>'modal-md',
    'options' => ['tabindex' => false ],
    'header'=>'',
    'headerOptions' => ['class'=>'default-modal'],
    // 'bodyOptions' => ['class'=>'modal-body body-file'],
    ]);
echo '
    <input type="hidden" id="lat-map" name="lat-map" value="0">
    <input type="hidden" id="lng-map" name="lng-map" value="0">
    <div class="wrap-maps">
        <div id="mapindex"></div>
    </div>';
echo '<hr/><div class="pull-right hidden-xs"><b>Version</b> 1.0</div><strong>Copyright &copy; 2019 <a href="http://www.hapindo.co.id/index.php">PT. Haleyora Powerindo</a>.</strong> All rights reserved.';
Modal::end(); 

$columns = 
[
    [
        'class'=>'kartik\grid\ExpandRowColumn',
        'expandTitle'=>'Detail Lembur',
        'value'=>function($model,$key,$index,$column) { return GridView::ROW_COLLAPSED;},
        'detail'=>function($model,$key,$index,$column) 
        {
            return $this->render('view', [
                'model' => $model,
                'key' => $key,
            ]);
        },
    ],
    // [
    //     'class' => 'kartik\grid\ActionColumn',
    //     'template' => '{update}',
    //     'visible'=> (Yii::$app->user->identity->JENIS == "2" OR Yii::$app->user->identity->JENIS == "1"),
    //     'noWrap'=>true,
    //     'buttons'=> [
    //         //view button
    //         'update' => function ($url, $model,$key) {
    //             return Html::a(
    //                 '<i class="glyphicon glyphicon-pencil"></i>',
    //                 $url,
    //                 [
    //                     'data-confirm' => 'Anda ingin mengubah data Lembur ini?',
    //                     'data-method'=>'post',
    //                     'type'=>'button',
    //                     'title'=>Yii::t('app', 'Update'), 
    //                 ]);
    //         },
    //     ]
    // ],
    [
        'attribute'=>'STATUS_PENGAJUAN',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=> ArrayHelper::map(DVal::find()->andWhere(['DESCRIPTION'=>'STATUS_PENGAJUAN'])->andWhere(['TABLE'=>'lembur'])->all(), 'KEY', 'VALUE'),
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'','id'=>'lembur-STATUS_PENGAJUAN'],
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
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'ID',
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
        'attribute'=>'PENEMPATAN',
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'JABATAN',
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'JENIS_LEMBUR',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=> ArrayHelper::map(DVal::find()->andWhere(['DESCRIPTION'=>'JENIS_LEMBUR'])->andWhere(['TABLE'=>'lembur'])->all(), 'KEY', 'VALUE'),
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'','id'=>'lembur-JENIS_LEMBUR'],
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'PEKERJAAN_LEMBUR',
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'ALAMAT',
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'label' => 'Map',
        'value' => function ($model) {
            if((EMPTY($model->LATITUDE) OR EMPTY($model->LONGITUDE))): 
                $model->LATITUDE = 38.685516;
                $model->LONGITUDE = -101.073324;
            endif;
            return 
            Html::a('<span class="glyphicon glyphicon-map-marker">', '#',
                [
                    'type'=>'button',
                    'class'=>'btn btn-xs btn-primary',
                    'data-toggle'=>'modal',
                    'data-target'=>'#modalmap',
                    'data-lat'=>$model->LATITUDE,
                    'data-lng'=>$model->LONGITUDE
                ]
            );
        },
        'mergeHeader' => true,
        'format' => 'raw',
        'noWrap' => true,
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'headerOptions' => ['style' => 'width:auto; white-space: normal; text-align:center;'],
    ],
    [
        'attribute'=>'JAM_AWAL_LEMBUR',
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
        'attribute'=>'JAM_AKHIR_LEMBUR',
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
        'attribute'=>'EVIDENCE_LEMBUR',
        'value'=>function($model){
            $dataToggle = "modal";
            $disabled = false;
            $spanClass = '<span class="glyphicon glyphicon-picture">';
            $btnClass = "btn btn-xs btn-info";
            if(empty($model->EVIDENCE_LEMBUR)): 
                $dataToggle = "";
                $disabled = true;
                $spanClass = '<span class="glyphicon glyphicon-ban-circle">';
                $btnClass = "btn btn-xs btn-danger";
            endif;
            return Html::a($spanClass, '#',
                [
                    'type'=>'button',
                    'class'=>$btnClass,
                    'data-toggle'=>$dataToggle,
                    'data-target'=>'#modalfiledownload',
                    'disabled'=>$disabled,
                    'data-whatever'=> $model->EVIDENCE_LEMBUR
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
        'label' => 'SPKL',
        'value' => function ($model) {
            return Html::a(
                '<i class="glyphicon glyphicon-list-alt"></i>',
                ['lembur/generate-spkl', 'id' => $model->ID],
                [
                    'type' => 'button',
                    'class' => 'btn btn-xs btn-primary',
                    'data-pjax'=>0
                ]
            );
        },
        'mergeHeader' => true,
        'format' => 'raw',
        'noWrap' => true,
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'headerOptions' => ['style' => 'width:auto; white-space: normal; text-align:center;'],
    ],
    [
        'attribute'=>'EVIDENCE_REALISASI',
        'value'=>function($model){
            $dataToggle = "modal";
            $disabled = false;
            $spanClass = '<span class="glyphicon glyphicon-picture">';
            $btnClass = "btn btn-xs btn-info";
            if(empty($model->EVIDENCE_REALISASI)): 
                $dataToggle = "";
                $disabled = true;
                $spanClass = '<span class="glyphicon glyphicon-ban-circle">';
                $btnClass = "btn btn-xs btn-danger";
            endif;
            return Html::a($spanClass, '#',
                [
                    'type'=>'button',
                    'class'=>$btnClass,
                    'data-toggle'=>$dataToggle,
                    'data-target'=>'#modalfiledownload',
                    'disabled'=>$disabled,
                    'data-whatever'=> $model->EVIDENCE_REALISASI
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
        'attribute'=>'TANGGAL_APPROVAL',
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
        'attribute'=>'TGL_REJECTED',
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
$print = 
[
    'STATUS_PENGAJUAN', 
    'CREATED_AT',
    'ID',
    'NO_INDUK',
    'NAMA',
    'PENEMPATAN',
    'JABATAN',
    'JENIS_LEMBUR',
    'PEKERJAAN_LEMBUR',
    'ALAMAT',
    'LATITUDE',
    'LONGITUDE',
    'JAM_AWAL_LEMBUR',
    'JAM_AKHIR_LEMBUR',
    'UPAH_PENGKALI',
    'JUMLAH_JAM',
    'TOTAL_UPAH_LEMBUR',
    'TANGGAL_APPROVAL',
    'TGL_REJECTED',
    'UPDATED_AT',
];

        $ExportMenu = ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns'=> $print,
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

<script type="text/javascript" async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjWx0439d2SRsgLLJmuh9VdrgyeYa1bdE&callback=initializeGMap&libraries=geometry,places"></script>
