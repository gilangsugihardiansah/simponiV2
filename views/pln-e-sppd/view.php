<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use app\models\PlnETarifSppd;
use app\models\PlnETarifSppdInter;

/* @var $this yii\web\View */
/* @var $model app\models\DataPengajuanSppd */

$modelTarifInter = PlnETarifSppdInter::find()->andWhere(['REGION'=>$model->WILAYAH])->one();
$modelTarifLokal = PlnETarifSppd::find()->andWhere(['COMPANY'=>'PLN E'])->one();

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
                    [        
                        'label' => 'Jenis SPPD',
                        'value' => $model->jenis->VALUE 
                    ],
                    'JENIS_SPPD',
                    'TGL_BERANGKAT',
                    'TGL_KEMBALI',
                    [        
                        'label' => 'Lumpsum',
                        'value' => $model->IS_LUMPSUM ? "Ya" : 'Tidak'
                    ],
                    [        
                        'label' => 'Region Tujuan',
                        'value' => $model->wil 
                    ],
                    'JENIS_TRANPORTASI',
                    'ASAL',
                    'TUJUAN',
                    'INSTANSI_TUJUAN',
                    'URAIAN_TUGAS:ntext',
                    // 'RATING',
                    [
                        'group'=>true,
                        'label'=>'Rician Tarif Perjalanan Dinas',
                        'rowOptions'=>['class'=>'info']
                    ],
                    [        
                        'label' => 'Tarif Uang Konsumsi per Hari',
                        'value' => isset($modelTarifInter->KONSUMSI) ? 'USD $'.Yii::$app->formatter->asDecimal($modelTarifInter->KONSUMSI,0) : 0,
                        'visible'=>$model->JENIS_SPPD == 'INTERNASIONAL',
                        'rowOptions'=>['class'=>'warning']
                    ],
                    [        
                        'label' => 'Tarif Uang Saku per Hari',
                        'value' => isset($modelTarifInter->UANG_SAKU) ? 'USD $'.Yii::$app->formatter->asDecimal($modelTarifInter->UANG_SAKU,0) : 0,
                        'visible'=>$model->JENIS_SPPD == 'INTERNASIONAL',
                        'rowOptions'=>['class'=>'warning']
                    ],
                    [        
                        'label' => 'Tarif Uang Konsumsi per Hari',
                        'value' => isset($modelTarifLokal->KONSUMSI) ? 'Rp. '.Yii::$app->formatter->asDecimal($modelTarifLokal->KONSUMSI,0) : 0,
                        'visible'=>$model->JENIS_SPPD == 'BIASA',
                        'rowOptions'=>['class'=>'warning']
                    ],
                    [        
                        'label' => 'Tarif Uang Laundry per Hari',
                        'value' => isset($modelTarifLokal->LAUNDRY) ? 'Rp. '.Yii::$app->formatter->asDecimal($modelTarifLokal->LAUNDRY,0) : 0,
                        'visible'=>$model->JENIS_SPPD != 'INTERNASIONAL',
                        'rowOptions'=>['class'=>'warning']
                    ],
                    [
                        'group'=>true,
                        'label'=>'Rician Pembayaran Perjalanan Dinas',
                        'rowOptions'=>['class'=>'info']
                    ],
                    [        
                        'label' => 'Jumlah Hari',
                        'value'=> $model->JUMLAH_HARI.' Hari',
                    ],
                    [        
                        'label' => 'Uang Konsumsi',
                        'value' => $model->JENIS_SPPD == 'INTERNASIONAL' ? 'USD $'.Yii::$app->formatter->asDecimal($model->KONSUMSI,0) : Yii::$app->formatter->asDecimal($model->KONSUMSI,0),
                        'visible'=>$model->JENIS_SPPD != 'KONSINYERING',
                    ],
                    [        
                        'label' => 'Uang Laundry',
                        'value' => !empty($model->LAUNDRY) ? 'Rp. '.Yii::$app->formatter->asDecimal($model->LAUNDRY,0) : 'Rp. 0',
                        'visible'=>$model->JENIS_SPPD != 'INTERNASIONAL',
                    ],
                    [        
                        'label' => 'Uang Saku',
                        'value' => 'USD $'.Yii::$app->formatter->asDecimal($model->UANG_SAKU,0),
                        'visible'=>$model->JENIS_SPPD == 'INTERNASIONAL',
                    ],
                    [        
                        'label' => 'Uang Tranportasi',
                        'value' => !empty($model->TRANPORTASI) ? 'Rp. '.Yii::$app->formatter->asDecimal($model->TRANPORTASI,0) : 'Rp. 0',
                        'visible'=>$model->JENIS_SPPD != 'INTERNASIONAL',
                    ],
                    [        
                        'label' => 'Total',
                        'value' => $model->JENIS_SPPD == 'INTERNASIONAL' ? 'USD $'.Yii::$app->formatter->asDecimal($model->TOTAL,0) : 'Rp. '.Yii::$app->formatter->asDecimal($model->TOTAL,0),
                        'rowOptions'=>['class'=>'warning']
                    ],
                    [        
                        'label' => 'Uang Lumpsum',
                        'value' => !empty($model->LUMPSUM) ? 'Rp. '.Yii::$app->formatter->asDecimal($model->LUMPSUM,0) : 'Rp. 0',
                        'visible'=>$model->JENIS_SPPD != 'INTERNASIONAL',
                    ],
                    [        
                        'label' => 'Kurs Dolar',
                        'value' => 'Rp. '.Yii::$app->formatter->asDecimal($model->KURS_DOLAR,0),
                        'visible'=> ($model->JENIS_SPPD == 'INTERNASIONAL' && $model->STATUS_PENGAJUAN == "3"),
                    ],
                    [        
                        'label' => 'Nominal DIbayarkan',
                        'value' => 'Rp. '.Yii::$app->formatter->asDecimal($model->NOMINAL,0),
                        'rowOptions'=>['class'=>'danger'],
                        'visible'=> ($model->JENIS_SPPD != 'INTERNASIONAL' || $model->STATUS_PENGAJUAN == "3"),
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
