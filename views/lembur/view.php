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
                        'label'=>'Informasi Lembur',
                        'rowOptions'=>['class'=>'info']
                    ],
                    'ID',
                    'JENIS_LEMBUR',
                    'PEKERJAAN_LEMBUR',
                    'ALAMAT',
                    'URAIAN_TUGAS_LEMBUR:ntext',
                    'JAM_AWAL_LEMBUR',
                    'JAM_AKHIR_LEMBUR',
                    // 'RATING',
                    [
                        'group'=>true,
                        'label'=>'Total Pembayaran Lembur',
                        'rowOptions'=>['class'=>'info']
                    ],
                    [        
                        'label' => 'Uang Pengkali',
                        'value' => !empty($model->UPAH_PENGKALI) ? Yii::$app->formatter->asDecimal($model->UPAH_PENGKALI,0) : '0' ,
                        'rowOptions'=>['class'=>'danger']
                    ],
                    'JUMLAH_JAM',
                    [        
                        'label' => 'Nominal Dibayarkan',
                        'value' => !empty($model->TOTAL_UPAH_LEMBUR) ? Yii::$app->formatter->asDecimal($model->TOTAL_UPAH_LEMBUR,0) : '0' ,
                        'rowOptions'=>['class'=>'danger']
                    ],
                    [        
                        'label' => 'Status Pengajuan',
                        'value' => $model->STATUS_PENGAJUAN,
                        'rowOptions'=>['class'=>'warning']
                    ],
                    [        
                        'attribute' => 'TANGGAL_APPROVAL',
                        'visible' => $model->STATUS_PENGAJUAN != "Pengajuan" ? true : false,
                        'value' => !empty($model->TANGGAL_APPROVAL) ? $model->TANGGAL_APPROVAL : '0000-00-00 00:00:00',
                    ]
                ],
            ]) ?>
        </div>
    </div>
</div>
