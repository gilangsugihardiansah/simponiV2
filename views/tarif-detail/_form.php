<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\export\ExportMenu;
use kartik\widgets\DatePicker;
use kartik\widgets\FileInput;
use app\models\Admin;
use app\models\Spk;
use app\models\TarifSppd;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Payroll */
/* @var $form yii\widgets\ActiveForm */

$dataCompany = ArrayHelper::map(Admin::find()->andWhere(['AND',['!=','JENIS','1'],['!=','JENIS','5']])->groupBy('COMPANY')->all(), 'COMPANY', 'COMPANY');
if(Yii::$app->user->identity->JENIS != "1"): 
    $dataCompany = ArrayHelper::map(Admin::find()->andWhere(['COMPANY'=>Yii::$app->user->identity->COMPANY])->groupBy('COMPANY')->all(), 'COMPANY', 'COMPANY');
endif;

?>

<div class="sppd-form">

    <?php $form = ActiveForm::begin([
        'type'=>ActiveForm::TYPE_VERTICAL, 
        'formConfig'=>['labelSpan'=>4],
        'action'=>$model->isNewRecord ? ['tarif-detail/create'] : ['tarif-detail/update','id'=>$model->NO_SPK],
        'options'=>['id' =>  'upload-payroll-form','enableAjaxValidation'=>true,'enctype'=>'multipart/form-data']
    ]); ?>
    <?= $form->field($model, 'COMPANY')->widget(Select2::classname(), [
            'data' => $dataCompany,
            'options' => ['placeholder' => '','id' => $model->isNewRecord ? 'create-COMPANY' : 'update-COMPANY'],
            'pluginOptions' => [
                'allowClear' => true
            ]
        ]);
    ?>
    <?= $form->field($model, 'NO_SPK')->widget(DepDrop::classname(), [
            'options' => ['placeholder' => 'Select ...','id' => $model->isNewRecord ? 'create-NO_SPK' : 'update-NO_SPK'],
            'type' => DepDrop::TYPE_SELECT2,
            'select2Options' => ['pluginOptions' => ['allowClear' => true]],
            'pluginOptions' => [
                'depends' => [
                    $model->isNewRecord ? 'create-COMPANY' : 'update-COMPANY',
                ],
                'initialize' => true,
                'url' => Url::to(['/spk/get-spk-by-app']),
                'params' => ['COMPANY'],
                'loadingText' => 'Select ...',
            ]
        ]);
    ?>
    <?= $form->field($model, 'ID_TARIF')->widget(DepDrop::classname(), [
            'options' => ['placeholder' => 'Select ...','id' => $model->isNewRecord ? 'create-ID_TARIF' : 'update-ID_TARIF'],
            'type' => DepDrop::TYPE_SELECT2,
            'select2Options' => ['pluginOptions' => ['allowClear' => true]],
            'pluginOptions' => [
                'depends' => [
                    $model->isNewRecord ? 'create-COMPANY' : 'update-COMPANY',
                ],
                'initialize' => true,
                'url' => Url::to(['/tarif-sppd/get-tarif-by-app']),
                'params' => ['COMPANY'],
                'loadingText' => 'Select ...',
            ]
        ])->label('Tarif SPPD')
    ?>

    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-save"></span> Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
