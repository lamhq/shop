<?php 
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;

yii\bootstrap\BootstrapPluginAsset::register($this);
sersid\fontawesome\Asset::register($this);
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
	<body>
		<?php $this->beginBody() ?>
		<div class="container">
			<?php echo Breadcrumbs::widget([
				'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
			]) ?>

			<?= \app\widgets\Alert::widget() ?>

			<?= $content; ?>
		</div>
		<?php $this->endBody() ?>
	</body>
</html>
<?php $this->endPage() ?>