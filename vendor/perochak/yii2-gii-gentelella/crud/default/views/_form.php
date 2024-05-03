<?php

use yii\helpers\Inflector;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="<?= Inflector::camel2id($generator->getModelNameForView()) ?>-form">

    <?= "<?php " ?>$form = ActiveForm::begin([
    'options'=>['class'=>'form-horizontal form-label-left']
    ]); ?>

<?php foreach ($safeAttributes as $attribute) {
    echo "    <?php echo " . $generator->generateActiveField($attribute) . " ?>\n\n";
} ?>
    <div class="ln_solid"></div>
    <div class="form-group">
        <div class='col-md-6 col-sm-6 col-xs-12 col-md-offset-3'>
        <?= "<?php echo " ?>Html::submitButton($model->isNewRecord ? <?= $generator->generateString('Create') ?> : <?= $generator->generateString('Update') ?>, ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?= "<?php " ?>ActiveForm::end(); ?>

</div>
