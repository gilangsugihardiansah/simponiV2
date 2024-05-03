<?php
use app\assets\AppAsset;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

dmstr\web\AdminLteAsset::register($this);
app\assets\AppAsset::register($this);

$this->title = "AMANDA-PT. Haleyora Powerindo";
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/files/backgrounds/logoa.png" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
	<style type="text/css">
		*{
			padding: 0;margin: 0;
		}
		html, body{
			background:#fff!important; 
		}
	</style>
    <?php $this->head() ?>
</head>
<body class="login-page">

<?php $this->beginBody() ?>
    <div class="wrapper wrap-login">
    	<?= $content ?>
    </div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
