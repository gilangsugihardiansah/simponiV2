<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\daterange\DateRangePicker;
use app\models\Pegawai;

/* @var $this yii\web\View */
/* @var $model app\models\KsoPayrollSearch */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="sppd-serach" style="overflow-x: hidden; padding:10px;">


    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_VERTICAL,
        // 'action'=>$model->isNewRecord ? ['admin/create'] : ['admin/update','id'=>$model->ID],
        'method' => 'post',
        'options'=>['id' =>  $id.'-report-form','enableAjaxValidation'=>true]
    ]); ?>

    <?= $form->field($searchModel, 'UPDATED_AT',['options' => ['class' => 'form-group col-md-12']])->widget(DateRangePicker::classname(), [
            'presetDropdown'=>false,
            'convertFormat'=>true,
            'includeMonthsFilter'=>true,
            'pluginOptions' => [
                'locale' => ['format' => 'Y-m-d'],
                
            ],
            'options' => [
                'placeholder' => 'Pilih Periode',
                'id' => 'UPDATED_AT-'.$id
            ]
        ])->label('Pilih Periode')
    ?>

    <div class="form-group col-md-12">
        <?= Html::submitButton('<span class="glyphicon glyphicon-print"></span> Print', ['class' => 'btn btn-success','name'=>$id,'value'=>$id]) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <br/>

</div>
