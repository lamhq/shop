<?php
use yii\bootstrap\Html;
use yii\helpers\Url;

$f = Yii::$app->formatter;
$itemCollection = $order->itemCollection;
$this->registerJs('app.setupCartDropdown();');
?>
<div class="btn-group btn-block cart-dropdown">
	<button type="button" data-toggle="dropdown" class="btn btn-inverse btn-block btn-lg dropdown-toggle" aria-expanded="false">
		<i class="fa fa-shopping-cart"></i> <span id="cart-total"><?= $f->asCurrency($order->calculateTotal()) ?></span>
	</button>
	<ul class="dropdown-menu pull-right">
	<?php if ($itemCollection->hasItems()): ?>
		<li>
			<table class="table table-striped">
				<tbody>
					<?php foreach ($itemCollection->getItems() as $item): ?>
					<?php $product = $item->product ?>
					<tr>
						<td class="text-center"><?= Html::img($product->getImageUrl(47, 47), ['class'=>'img-thumbnail']) ?></td>
						<td class="text-left"><?= Html::a($product->name, $product->getUrl()) ?></td>
						<td class="text-right">x <?= $item->quantity ?></td>
						<td class="text-right"><?= $f->asCurrency($item->getTotal()) ?></td>
						<td class="text-center">
							<button type="button" title="<?= Yii::t('app', 'Remove') ?>" class="btn btn-danger btn-xs btn-remove" data-item="<?= $item->id ?>"><i class="fa fa-times"></i></button>
						</td>
					</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</li>
		<li>
			<table class="table table-bordered">
				<tbody>
				<?php foreach ($order->collectPrices() as $item): ?>
					<tr>
						<td class="text-right"><strong><?= $item['title'] ?></strong></td>
						<td class="text-right"><?= $f->asCurrency($item['value']) ?></td>
					</tr>
				<?php endforeach ?>
				</tbody>
			</table>
			<p class="text-right">
				<a href="<?= Url::to(['/shop/cart']) ?>"><strong><i class="fa fa-shopping-cart"></i> <?= Yii::t('shop', 'Checkout') ?></strong></a>
			</p>
		</li>
	<?php else: ?>
			<li><p class="text-center"><?= Yii::t('shop', 'Your shopping cart is empty!') ?></p></li>
	<?php endif ?>
	</ul>
</div>