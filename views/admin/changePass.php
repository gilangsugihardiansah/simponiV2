<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\form\ActiveForm;
use kartik\editable\Editable;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\number\NumberControl;
use yii\widgets\MaskedInput;
/* @var $this yii\web\View */
/* @var $model common\models\Pegawai */

// $this->title = $model->NAMA;
// $post = substr($model->NAMA,0,3).'PRF'.substr($model->NAMA,-3);

if(Yii::$app->session->hasFlash('info')):
    Yii::$app->session->getFlash('info');
endif;

?>
<div class="panel panel-default pegawai-profil-view" id="profil-view" oncontextmenu='return false;' style='-moz-user-select: none; cursor: default;'>
    <div class="panel-heading">
        <h3 class="panel-title"><span class="glyphicon glyphicon-pencil"></span> Update Password </h3>
    </div>

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL, 'formConfig'=>['labelSpan'=>4],'options'=>['id' =>  'update-profil-form','enableAjaxValidation'=>true]  ]); ?>

    <div class='panel-body'>
        <div class='col-md-12' style="padding:0; margin:0;">
            <div class='col-md-12'>
                <?= $form->field($model, 'PASSWORD_LAMA')->passwordInput(['maxlength' => true]) ?>
            </div>
            <div class='col-md-12'>
                <?= $form->field($model, 'PASSWORD_BARU')->passwordInput(['maxlength' => true]) ?>
            </div>
            <div class='col-md-12'>
                <?= $form->field($model, 'PASSWORD_BARU_REPEAT')->passwordInput(['maxlength' => true]) ?>
            </div>
        </div>
            <div class='col-md-6'>
                <?= Html::submitButton('<i class="glyphicon glyphicon-save"></i> Simpan', ['class' => 'btn btn-primary']) ?>
            </div>
        <!-- </div>
        <div class='col-md-6'>
        </div> -->
    </div>

    <?php ActiveForm::end() ?>

</div>


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