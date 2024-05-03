<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Url; 
use kartik\select2\Select2;
use kartik\widgets\DatePicker;
use app\models\MasterKabupaten;
use kartik\widgets\TypeaheadBasic;

/* @var $this yii\web\View */
/* @var $model app\models\DataPengajuanSppd */

$this->title = Yii::t('app', 'Approval {modelClass}: ', [
    'modelClass' => 'No. Reimburse',
]) . $model->ID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pengajuan Reimburse'), 'url' => ['index-app']];
$this->params['breadcrumbs'][] = $this->title;

if (Yii::$app->session->hasFlash('error')):
   echo '<div class="alert alert-danger" style="font-size: 11px;">';
   echo Yii::$app->session->getFlash('error');
   echo '</div>';
endif;


?>

<div class="form-box">
    <?php 
        $form = ActiveForm::begin([
            'type' => ActiveForm::TYPE_VERTICAL,
            'options'=>[
                'id' =>  'app-reim',
                'enableAjaxValidation'=>true,
                'enctype'=>'multipart/form-data'
            ]
        ]); 
    ?>
    <div class="row">
        <div class="col-md-12">
            <h3><?=$this->title?></h3>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'TGL_SERVICE')->widget(DatePicker::classname(), 
                [
                    'pluginOptions' => 
                    [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true,
                    ]
                ]); 
            ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'NO_POL')->textInput() ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'NOMINAL')->textInput(['type'=>'number']) ?>
        </div>
    </div>

    <div class="row" style="margin-right: 0px;">
        <div class="col-md-12">
            <?= $form->field($model, 'STATUS_PENGAJUAN')->hiddenInput(['value' => '1'])->label(false) ?>
            <?=
                Html::submitButton('<span class="glyphicon glyphicon-ok"></span>'. Yii::t('app', ' Approved'), ['class' => 'btn btn-sm btn-primary']).'&nbsp'.
                Html::a('<span class="glyphicon glyphicon-arrow-left"></span>'. Yii::t('app', ' Kembali'), ['index-app'], ['class' => 'btn btn-sm btn-info'])
            ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<br/>

<?php
    $this->registerJs('
        document.addEventListener("contextmenu", function(e){
            e.preventDefault();
        }, false);
        document.onkeydown = function(e) {
            if(event.keyCode == 123) {
                return false;
            }
            if(e.ctrlKey && e.shiftKey && e.keyCode == "I".charCodeAt(0)){
                return false;
            }
            if(e.ctrlKey && e.shiftKey && e.keyCode == "J".charCodeAt(0)){
                return false;
            }
            if(e.ctrlKey && e.keyCode == "U".charCodeAt(0)){
                return false;
            }
        };
    ');
?>
