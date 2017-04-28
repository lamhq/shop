<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;

$title = Yii::t('shop', 'Your order has been placed!');
?>
<h1><?= $title ?></h1>

<p>Your order has been successfully processed!</p>

<?php if (!Yii::$app->user->isGuest): ?>
<p>You can view your order history by going to the <a href="<?= Url::to(['account/account']) ?>">my account</a> page and by clicking on <a href="<?= Url::to(['account/order']) ?>">history</a>.</p>
<?php endif ?>

<p>Please direct any questions you have to the <a href="<?= Url::to(['default/contact']) ?>">store owner</a>.</p>

<p>Thanks for shopping with us online!</p>

<div class="buttons">
	<div class="pull-right">
		<a href="<?= Url::home() ?>" class="btn btn-primary">Continue</a>
	</div>
</div>
