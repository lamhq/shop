<?php 
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;

yii\bootstrap\BootstrapPluginAsset::register($this);
sersid\fontawesome\Asset::register($this);
\shop\assets\Shop::register($this);
$this->addBodyClass(Yii::$app->controller->id.'-'.Yii::$app->controller->action->id);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title><?= Html::encode($this->title) ?></title>
		<?php $this->head() ?>
		<?= Html::csrfMetaTags() ?>
	</head>
	<body class="<?= $this->getBodyClass() ?>">
		<?php $this->beginBody() ?>
		<?= $this->render('_header') ?>
		
		<div class="container">
			<?php echo Breadcrumbs::widget([
				'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
			]) ?>

			<?= \app\widgets\Alert::widget() ?>

			<?= $content; ?>
		</div>

		<?= $this->render('_footer') ?>
		<?php $this->endBody() ?>
	</body>
</html>
<?php $this->endPage() ?>