<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use shop\models\CheckoutForm;

/* @var $this yii\web\View */
/* @var $model shop\models\CheckoutForm */
$f = Yii::$app->formatter;
?>
<h3><?= Yii::t('shop', 'Review') ?></h3>

<table class="table table-bordered">
	<tbody>
	<?php foreach ($model->collectPrices() as $item): ?>
		<tr>
			<td class="text-right"><strong><?= $item['title'] ?></strong></td>
			<td class="text-right"><?= $f->asCurrency($item['value']) ?></td>
		</tr>
	<?php endforeach ?>
	</tbody>
</table>

<div class="buttons clearfix">
	<div class="pull-left"><a href="<?= Yii::$app->homeUrl ?>" class="btn btn-default"><?= Yii::t('shop', 'Continue Shopping') ?></a></div>
	<div class="pull-right">
		<button type="button" data-loading-text="<?= Yii::t('app', 'Loading...') ?>" class="btn btn-primary btn-lg btn-order"><?= Yii::t('shop', 'Place Order') ?></button>
	</div>
</div>
