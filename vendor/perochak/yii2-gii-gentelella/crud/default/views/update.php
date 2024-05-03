<?php

use yii\helpers\Inflector;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = <?= $generator->generateString('Update {modelClass}: ', ['modelClass' => Inflector::camel2words($generator->getModelNameForView())]) ?> . ' ' . $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words($generator->getModelNameForView()))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = <?= $generator->generateString('Update') ?>;
?>
<div class='row'>
    <div class='col-md-12 col-sm-12 col-xs-12'>
<div class="<?= Inflector::camel2id($generator->getModelNameForView()) ?>-update x_panel">
    <div class='x_title'>
    <h2><?= "<?php echo " ?>Html::encode($this->title) ?></h2>
    <div class="clearfix"></div>
    </div>
    <div class='x_content'>
    <?= "<?php echo " ?>$this->render('_form', [
        'model' => $model,
        
    ]) ?>
    </div>

</div>
    </div>
</div>