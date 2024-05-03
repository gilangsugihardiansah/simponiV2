<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use kartik\widgets\FileInput;
use yii\helpers\ArrayHelper;
use app\models\Admin;
use app\models\JenisUser;
use yii\data\ArrayDataProvider;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PayrollSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Admin Aplikasi';
$this->params['breadcrumbs'][] = $this->title;

Modal::begin([
    'id'=>'create',
    'options' => ['tabindex' => false ],
    'size'=>'modal-md',
    'header' => 'Tambah '.$this->title,
    'headerOptions' => ['class'=>'modal-header'],
    'bodyOptions' => ['class'=>'modal-body bg-white body-create'],
    ]);
echo $this->render('_form', [
    'model' => new Admin(),
]);
Modal::end(); 

$columns = 
[
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{update} {delete}',
    ],
    [
        'attribute'=>'USERNAME',
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
        'attribute'=>'JENIS',
        'value'=>'jen.JENIS_USER',
        'filter'=>ArrayHelper::map(JenisUser::find()->asArray()->all(), 'ID', 'JENIS_USER'),
        'filterType'=>GridView::FILTER_SELECT2,
        'filterWidgetOptions'=>['pluginOptions'=>['allowClear'=>true]],
        'filterInputOptions'=>['placeholder'=>''],
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'COMPANY',
        // 'mergeHeader'=>true,
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'UNIT',
        'value'=>'bidang',
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        // 'pageSummary'=>true,
    ],
    [
        'attribute'=>'DATA_BAWAHAN',
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>false,
        'format'=>'html',
        'value'=>function($model){
            if($model->JENIS == "7" OR $model->JENIS == "8"): 
                $bawahans = explode(";", $model->DATA_BAWAHAN);
                $list = null;
                foreach ($bawahans as $key => $bawahan):
                    $list = $list."<li>".$model->getDataPegawai($bawahan)['NAMA']."</li>";
                endforeach;
                return "<ol>".$list."</ol>";
            else: 
                return null;
            endif;
        },
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
            Html::a('<span class="glyphicon glyphicon-plus"></span>', ['#'], ['class' => 'btn btn-default','data-toggle'=>'modal','data-target'=>'#create']),
            [
                'content'=> $ExportMenu
            ],
            '{toggleData}'
        ],
        'columns' => $columns,
    ]); ?>
</div>