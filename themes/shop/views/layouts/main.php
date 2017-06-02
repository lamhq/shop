<?php 
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;

yii\bootstrap\BootstrapPluginAsset::register($this);
sersid\fontawesome\Asset::register($this);
\shop\assets\Shop::register($this);
$this->registerCssFile($this->theme->getUrl('css/style.css'), [
	'depends' => [\yii\bootstrap\BootstrapAsset::className()],
]);
$this->registerCssFile('//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700');
$this->registerJs('app.setupNotifyJs();');
$this->addBodyClass(Yii::$app->controller->id.'-'.Yii::$app->controller->action->id);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
	<head>
		<meta charset="<?= Yii::$app->charset ?>"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<link href="<?= Yii::$app->helper->getFaviconUrl() ?>" rel="icon" />

		<title><?= Html::encode($this->title) ?></title>
		<?php $this->head() ?>
		<?= Html::csrfMetaTags() ?>
	</head>
	<body class="<?= $this->getBodyClass() ?>">
		<?php $this->beginBody() ?>
		<?= $this->render('_header') ?>
		
		<div class="container">
			<?php echo Breadcrumbs::widget([
				'homeLink' => [
					'label' => '<i class="fa fa-home"></i>',
					'url' => Yii::$app->homeUrl,
					'encode'=>false,
				],
				'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
			]) ?>

			<?= \app\widgets\Alert::widget() ?>

			<div class="row">
				<div id="content" class="col-sm-12"><?= $content; ?></div>
			</div>
		</div>

		<?= $this->render('_footer') ?>
		<?php $this->endBody() ?>
	</body>
</html>
<?php $this->endPage() ?>