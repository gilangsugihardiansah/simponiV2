<?php
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;
use app\assets\AppAsset;

AppAsset::register($this);

?>
<div class="content-wrapper">
    <section class="content">
        <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </section>
</div>

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 1.0
    </div>
    <strong>Copyright &copy; 2019-<?=date('Y')?> <a href="#">PT. HALEYORA POWERINDO</a>.</strong> All rights
    reserved.
</footer>