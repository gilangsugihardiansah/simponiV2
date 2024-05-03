<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use kartik\widgets\FileInput;
use yii\helpers\ArrayHelper;
use app\models\PusharlisLembur;
use app\models\DVal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PayrollSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Pengajuan Lembur';
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

Modal::begin([
    'id'=>'rejected',
    'size'=>'modal-md',
    'header'=>'<h5 id="header-rejected">Confirmation</h5>',
    'headerOptions' => ['class'=>'danger-modal'],
    ]);
echo $this->render('rejected', [
    'model' => new PusharlisLembur(),
]);
Modal::end(); 

$this->registerJs(
    "$('#rejected').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var key = button.data('key');
        $('#pusharlislembur-id').attr('value',key);
    })"
);

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
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{update} {update-rej}',
        'visible'=> (Yii::$app->user->identity->JENIS == "10" OR Yii::$app->user->identity->JENIS == "11"),
        'noWrap'=>true,
        'buttons'=> [
            //view button
            'update' => function ($url, $model,$key) {
                if($model->STATUS_PENGAJUAN == "2"):
                    $text = "rekomendasikan";
                    $url = $url.'&key=3';
                elseif($model->STATUS_PENGAJUAN == "3"):
                    $text = "menyetujui";
                    $url = $url.'&key=4';
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
        'attribute'=>'ID',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=> ArrayHelper::map(PusharlisLembur::find()->select('ID')->groupBy(['ID'])->asArray()->all(), 'ID', 'ID'),
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'','id'=>'lembur-ID'],
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'NO_INDUK',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=> ArrayHelper::map(PusharlisLembur::find()->select('NO_INDUK')->groupBy(['NO_INDUK'])->asArray()->all(), 'NO_INDUK', 'NO_INDUK'),
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'','id'=>'lembur-NO_INDUK'],
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'NAMA',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=> ArrayHelper::map(PusharlisLembur::find()->select('NAMA')->groupBy(['NAMA'])->asArray()->all(), 'NAMA', 'NAMA'),
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'','id'=>'lembur-NAMA'],
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>false,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'PENEMPATAN',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=> ArrayHelper::map(PusharlisLembur::find()->select('PENEMPATAN')->groupBy(['PENEMPATAN'])->asArray()->all(), 'PENEMPATAN', 'PENEMPATAN'),
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'','id'=>'lembur-PENEMPATAN'],
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>false,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'JABATAN',
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=> ArrayHelper::map(PusharlisLembur::find()->select('JABATAN')->groupBy(['JABATAN'])->asArray()->all(), 'JABATAN', 'JABATAN'),
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'','id'=>'lembur-JABATAN'],
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>false,
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
        'mergeHeader' => true,
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>false,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'ALAMAT',
        'mergeHeader' => true,
        'value' => function ($model) {
            if((EMPTY($model->LATITUDE) OR EMPTY($model->LONGITUDE))): 
                $model->LATITUDE = 38.685516;
                $model->LONGITUDE = -101.073324;
            endif;
            return 
            $model->ALAMAT.
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
        'format' => 'raw',
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>false,
        // 'pageSummary'=>true,
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
        'noWrap'=>false,
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
        'noWrap'=>false,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'JUMLAH_JAM',
        'format' => ['decimal',0],
        'mergeHeader' => true,
        'hAlign'=>'right',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        'pageSummary'=>true,
    ],
    [
        'attribute'=>'TOTAL_UPAH_LEMBUR',
        'format' => ['decimal',0],
        'mergeHeader' => true,
        'hAlign'=>'right',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        'pageSummary'=>true,
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
        'noWrap'=>false,
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
                ['pusharlis-lembur/generate-spkl', 'id' => $model->ID],
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
        'showPageSummary'=>false,
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

<script type="text/javascript" async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjWx0439d2SRsgLLJmuh9VdrgyeYa1bdE&callback=initializeGMap&libraries=geometry,places"></script>