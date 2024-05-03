<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use kartik\widgets\FileInput;
use yii\helpers\ArrayHelper;
use app\models\PlnETarifSppdInter;
use app\models\PlnERegion;
use yii\data\ArrayDataProvider;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PayrollSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Tarif SPPD Internasional';
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
    'model' => new PlnETarifSppdInter(),
]);
Modal::end(); 

$columns = 
[
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{update} {delete}',
    ],
    [
        'attribute'=>'REGION',
        'value'=>'reg.REGION',
        'filter'=>ArrayHelper::map(PlnERegion::find()->asArray()->all(), 'ID', 'REGION'),
        'filterType'=>GridView::FILTER_SELECT2,
        'filterWidgetOptions'=>['pluginOptions'=>['allowClear'=>true]],
        'filterInputOptions'=>['placeholder'=>''],
        'hAlign'=>'left',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
    ],
    [
        'attribute'=>'KONSUMSI',
        'mergeHeader'=>true,
        'hAlign'=>'right',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        'format'=>['Currency'],
    ],
    [
        'attribute'=>'UANG_SAKU',
        'mergeHeader'=>true,
        'hAlign'=>'right',
        'vAlign'=>'middle',
        'headerOptions'=>['style' => 'width:auto; white-space: normal; text-align:center;'],
        'noWrap'=>true,
        'format'=>['currency'],
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