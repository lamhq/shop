<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;

$h = Yii::$app->helper;
$title = Yii::t('shop', 'Your order has been placed!');
$this->title = $h->getPageTitle($title);
?>
<h1><?= $title ?></h1>

<p><?= Yii::t('shop', 'Your order number is: ') ?>: <strong>#<?= $model->id ?></strong></p>

<?php if (!Yii::$app->user->isGuest): ?>
<p><?= Yii::t('shop', 'You can view your order history by going to the {0} page and by clicking on {1}.', [
	Html::a(Yii::t('app', 'My Account'), ['account/account']),
	Html::a(Yii::t('shop', 'Order History'), ['account/order']),
]) ?></p>
<?php endif ?>

<p><?= Yii::t('shop', 'Please direct any questions you have to {0}', 
	Html::a(Yii::t('shop', 'store owner'), $h->getPageUrl('gioi-thieu'))) ?></p>

<p><?= Yii::t('shop', 'Thanks for shopping with us online!') ?></p>

<div class="buttons">
	<div class="pull-right">
		<a href="<?= Url::home() ?>" class="btn btn-primary"><?= Yii::t('shop', 'Continue') ?></a>
	</div>
</div>
