<?php
use yii\helpers\Html;
use kartik\tabs\TabsX;
use yii\helpers\Url;

$items = [
    [
        'label'=>'<i class="fa fa-user"></i> Admin',
        'content'=>$this->render('index-creator',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]),
        'active'=>true,
        // 'linkOptions'=>['data-url'=>Url::to("index.php?r=site/fetch-tab&tab=1")]
    ],
];

?>
<div class="site-index">
    <div class="panel panel-default pegawai-profil-view" id="profil-view" oncontextmenu='return false;' style='-moz-user-select: none; cursor: default; padding:0 15px 15px 15px; opacity: 0.9;'>
        <br/>
            <?= TabsX::widget([
                'items'=>$items,
                'position'=>TabsX::POS_ABOVE,
                'height'=>TabsX::SIZE_LARGE,
                'bordered'=>true,
                'encodeLabels'=>false
            ]);?>
        </div>
    </div>
</div>
