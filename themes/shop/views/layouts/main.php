<?php 
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;

$leftColumn = trim(ArrayHelper::getValue($this->blocks, 'leftColumn'));
$rightColumn = ArrayHelper::getValue($this->blocks, 'rightColumn');
$topContent = ArrayHelper::getValue($this->blocks, 'topContent');
$bottomContent = ArrayHelper::getValue($this->blocks, 'bottomContent');

// determine width of main column
if ($leftColumn && $rightColumn) {
	$contentClass = 'col-sm-6';
} elseif ($leftColumn || $rightColumn) {
	$contentClass = 'col-sm-9';
} else {
	$contentClass = 'col-sm-12';
}

\yii\bootstrap\BootstrapPluginAsset::register($this);
\sersid\fontawesome\Asset::register($this);
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
				<?php if ($leftColumn): ?>
				<aside id="column-left" class="col-sm-3">
					<?= $leftColumn ?>
				</aside>
				<?php endif ?>

				<div id="content" class="<?= $contentClass ?>">
					<?= $topContent ?>
					<?= $content; ?>
					<?= $bottomContent; ?>
				</div>

				<?php if ($rightColumn): ?>
				<aside id="column-right" class="col-sm-3">
					<?= $rightColumn ?>
				</aside>
				<?php endif ?>
			</div>
		</div>

		<?= $this->render('_footer') ?>
		<?php $this->endBody() ?>
	</body>
</html>
<?php $this->endPage() ?>