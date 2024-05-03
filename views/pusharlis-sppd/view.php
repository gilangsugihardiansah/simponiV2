<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DataPengajuanSppd */
?>
<div class="data-pengajuan-sppd-view">
    <div class="panel panel-default">
        <div class="panel-body">

            <?= DetailView::widget([
                'model'=>$model,
                'condensed'=>true,
                'hover'=>true,
                'mode'=>DetailView::MODE_VIEW,
                'panel'=>false,
                'buttons1'=>'',
                'labelColOptions'=>['style'=>' text-align:center !important; width:20%; color:#286090; font-size:13px; white-space: normal;'],
                'valueColOptions'=>['style' => 'width:80%; white-space: normal; text-align:left;'],
                'hAlign'=>'left',
                'attributes' => [
                    [
                        'group'=>true,
                        'label'=>'Informasi Perjalanan Dinas',
                        'rowOptions'=>['class'=>'info']
                    ],
                    'ID',
                    'CREATED_AT',
                    'STATUS_SPPD',
                    'TGL_BERANGKAT',
                    'TGL_KEMBALI',
                    'JUMLAH_HARI',
                    'KOTA_ASAL',
                    'KOTA_TUJUAN',
                    'INSTANSI_TUJUAN',
                    'NAMA_ATASAN_PLN',
                    'NO_WA_ATASAN_PLN',
                    'URAIAN_TUGAS:ntext',
                    // 'RATING',
                    [
                        'group'=>true,
                        'label'=>'Total Pembayaran Perjalanan Dinas',
                        'rowOptions'=>['class'=>'info']
                    ],
                    [        
                        'label' => 'Nominal Dibayarkan',
                        'value' => !empty($model->TOTAL) ? Yii::$app->formatter->asDecimal($model->TOTAL,0) : '0' ,
                        'rowOptions'=>['class'=>'danger']
                    ],
                    [        
                        'label' => 'Status Pengajuan',
                        'value' => "<span class='badge' style='background-color: {$model->colors}'>{$model->status->VALUE}</span>",
                        'format'=>'html',
                        'rowOptions'=>['class'=>'warning']
                    ],
                    'UPDATED_AT',
                ],
            ]) ?>
        </div>
    </div>
</div>
