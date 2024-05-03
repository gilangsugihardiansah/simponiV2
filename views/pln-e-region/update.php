<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Akademis */

$this->title = 'Update Region: ' . $model->ID;
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="region">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
