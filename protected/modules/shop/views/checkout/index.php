<?php
/* @var $this \yii\web\View */
/* @var $cart shop\components\Cart */
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;

$this->registerJs('app.setupCheckoutPage();');
$this->title = Yii::$app->helper->getPageTitle(Yii::t('shop', 'Checkout'));
$this->params['breadcrumbs'][] = $this->title;
$f = Yii::$app->formatter;
\app\assets\Select2BootstrapTheme::register($this);
?>
<h1><?= $this->title ?></h1>
<div class="panel-group" id="accordion">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title"><?= Yii::t('shop', 'Step 1') ?>: <?= Yii::t('shop', 'Delivery Details') ?> </h4>
		</div>
		<div class="panel-collapse collapse" id="collapse-shipping-address">
			<div class="panel-body"></div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title"><?= Yii::t('shop', 'Step 2') ?>: <?= Yii::t('shop', 'Confirm Order') ?></h4>
		</div>
		<div class="panel-collapse collapse" id="collapse-checkout-confirm">
			<div class="panel-body"></div>
		</div>
	</div>
</div>
