<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Akademis */

$this->title = 'Update Jenis User: ' . $model->JENIS_USER;
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="JENIS_USER-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
