<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\export\ExportMenu;
use kartik\widgets\DatePicker;
use kartik\widgets\FileInput;
use app\models\Admin;
use app\models\Spk;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Payroll */
/* @var $form yii\widgets\ActiveForm */


$style = "display:none";
if(Yii::$app->user->identity->JENIS == "1"): 
    $style = "display:blok";
endif;

?>

<div class="sppd-form">

    <?php $form = ActiveForm::begin([
        'type'=>ActiveForm::TYPE_VERTICAL, 
        'formConfig'=>['labelSpan'=>4],
        'action'=>$model->isNewRecord ? ['tarif-sppd/create'] : ['tarif-sppd/update','id'=>$model->ID],
        'options'=>['id' =>  'upload-payroll-form','enableAjaxValidation'=>true,'enctype'=>'multipart/form-data']
    ]); ?>
    <?= $form->field($model, 'TARIF_AKOMODASI')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TARIF_MENGINAP')->textInput(['maxlength' => true]) ?>

    <div style=<?=$style?> >
        <?= $form->field($model, 'COMPANY')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Admin::find()->andWhere(['AND',['!=','JENIS','1'],['!=','JENIS','5']])->groupBy('COMPANY')->all(), 'COMPANY', 'COMPANY'),
                'pluginOptions' => [
                    'allowClear' => false
                ],
            ]) 
        ?>
    </div>
    
    <?php 
        // $form->field($model, 'NO_SPK')->widget(Select2::classname(), [
        //     'data' => ArrayHelper::map(Spk::find()->andWhere(['APP'=>'JATENG'])->groupBy('COMPANY')->all(), 'COMPANY', 'COMPANY'),
        //     'pluginOptions' => [
        //         'allowClear' => false
        //     ],
        // ]) 
    ?>

    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-save"></span> Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
