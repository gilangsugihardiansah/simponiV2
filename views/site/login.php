<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use buttflattery\formwizard\FormWizard;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Sign In';
?>

<div class="login-box">
    <div class="login-logo" style="text-shadow: 2px 2px rgba(236, 240, 243);">
        <?=Html::img('@web/files/backgrounds/logo.png',['class' => 'image','style'=>'width:60px; height:60px; border-radius:2px; margin-bottom:7px;'])?><b>MANDA</b>App</a>
                <hr style='border:3px solid #7D7D7D;'/>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body" style="background:#fff;padding:20px;border:2px solid #ECF0F3 !important;color:#666;border-radius: 2px;box-shadow:0px 5px 5px 5px rgba(236, 240, 243);">
        <h3 class="signup-title"><b>Masuk</b></h3>

        <?php $form = ActiveForm::begin(['id' => 'login-form','type' => ActiveForm::TYPE_VERTICAL, 'enableClientValidation' => false]); ?>

        <?= $form->field($model, 'username',[
            'options' => ['class' => 'form-group has-feedback input-bor'],
            'feedbackIcon' => [
                'type'=>'raw',
                'default' => '<i class="fa fa-user"></i>',
                'success' => 'check text-success',
                'error' => '<span style="color: #ffa3a8;"><i class="fa fa-user"></i></span>',
                'defaultOptions' => ['class'=>'text-warning']
            ],
            'autoPlaceholder'=>true
        ])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'password',[
            'feedbackIcon' => [
                'type'=>'raw',
                'default' => '<i class="fa fa-lock"></i>',
                'success' => '<span style="color: #93c08c;"><i class="fa fa-lock"></i></span>',
                'error' => '<span style="color: #ffa3a8;"><i class="fa fa-lock"></i></span>',
                'defaultOptions' => ['class'=>'text-warning']
            ],
            'autoPlaceholder'=>true
        ])->passwordInput(['maxlength' => true]) ?>

        <div class="row">
            <div class="col-xs-12">
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
            </div>
            <div class="col-xs-12">
                <?= Html::submitButton('Masuk', ['class' => 'btn btn-primary btn-block btn-flat btn-login', 'name' => 'login-button', 'style'=>'font-size: 14px;height: 48px;line-height: 32px;padding: 8px 16px;font-weight: 600;box-sizing: border-box;transition: all .3s ease;border-radius: 4px;']) ?>
            </div>
        </div>


        <?php ActiveForm::end(); ?>
        <!-- /.social-auth-links -->

    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
