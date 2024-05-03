<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;

/* @var $this \yii\web\View */
/* @var $content string */


if (Yii::$app->controller->action->id === 'login'):
/**
 * Do not use this code in your template. Remove it. 
 * Instead, use the code  $this->layout = '//main-login'; in your controller.
 */
    echo $this->render(
        'main-login',
        ['content' => $content]
    );

// elseif (Yii::$app->controller->action->id === 'login'):
//     /**
//      * Do not use this code in your template. Remove it. 
//      * Instead, use the code  $this->layout = '//main-login'; in your controller.
//      */
//         echo $this->render(
//             'main-login',
//             ['content' => $content]
//         );
    
else:
    dmstr\web\AdminLteAsset::register($this);

    app\assets\AppAsset::register($this);

    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');

    $this->title = "AMANDA-APP";

    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    	<link rel="shortcut icon" href="/files/backgrounds/logoa.png" />
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="hold-transition skin-blue sidebar-collapse sidebar-mini">
    <?php $this->beginBody() ?>
    <div class="wrapper">

        <?= (!Yii::$app->user->isGuest) ? $this->render(
            'header.php',
            ['directoryAsset' => $directoryAsset]
        ) : '' ?>

        <?= (!Yii::$app->user->isGuest) ? $this->render(
            'left.php',
            ['directoryAsset' => $directoryAsset]
        ) : ''
        ?>

        <?= $this->render(
            'content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>

    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>
<?php 
endif;
?>
