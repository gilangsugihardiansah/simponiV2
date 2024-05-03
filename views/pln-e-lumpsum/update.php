<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Akademis */

$this->title = 'Update Tarif Lumpsum: ' . $model->ID;
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tarif-sppd">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
