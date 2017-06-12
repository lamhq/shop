<?php
$f = Yii::$app->formatter;
?>
<table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
	<thead>
		<tr>
			<td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;" colspan="2"><?= Yii::t('shop', 'Order Details') ?></td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">
				<b><?= Yii::t('shop', 'Order ID') ?>:</b> #<?= $order->id; ?><br />
				<b><?= Yii::t('shop', 'Create Time') ?>:</b> <?= $f->asDate($order->created_at) ?><br />
				<b><?= Yii::t('shop', 'Payment Method') ?>:</b> <?= $order->payment_method; ?><br />
			</td>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">
				<b><?= Yii::t('shop', 'Name') ?>:</b> <?= $order->name; ?><br />
				<?php if ($order->email): ?>
				<b><?= Yii::t('shop', 'Email') ?>:</b> <?= $order->email; ?><br />
				<?php endif ?>
				<b><?= Yii::t('shop', 'Telephone') ?>:</b> <?= $order->telephone; ?><br />
				<b><?= Yii::t('shop', 'Status') ?>:</b> <?= $order->getDisplayStatus(); ?><br />
			</td>
		</tr>
	</tbody>
</table>

<?php if ($order->comment): ?>
<table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
	<thead>
		<tr>
			<td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;"><?= Yii::t('shop', 'Comment') ?></td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?= $order->comment; ?></td>
		</tr>
	</tbody>
</table>
<?php endif ?>

<table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
	<thead>
		<tr>
			<td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;"><?= Yii::t('shop', 'Shipping Detail') ?></td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">
				<b><?= Yii::t('shop', 'Name') ?>:</b> <?= $order->shipping_name ?><br/>
				<b><?= Yii::t('shop', 'City') ?>:</b> <?= $order->shippingCity->name ?><br/>
				<b><?= Yii::t('shop', 'District') ?>:</b> <?= $order->shippingDistrict ? $order->shippingDistrict->name : '' ?><br/>
				<b><?= Yii::t('shop', 'Ward') ?>:</b> <?= $order->shippingWard ? $order->shippingWard->name : '' ?><br/>
				<b><?= Yii::t('shop', 'Address') ?>:</b> <?= $order->shipping_address ?>
			</td>
		</tr>
	</tbody>
</table>

<table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
	<thead>
		<tr>
			<td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;"><?= Yii::t('shop', 'Product') ?></td>
			<td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;"><?= Yii::t('shop', 'Quantity') ?></td>
			<td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: right; padding: 7px; color: #222222;"><?= Yii::t('shop', 'Unit Price') ?></td>
			<td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: right; padding: 7px; color: #222222;"><?= Yii::t('shop', 'Total') ?></td>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($order->orderProducts as $item): ?>
		<tr>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?= $item->product->name; ?>
			</td>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><?= $item->quantity; ?></td>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><?= $f->asCurrency($item->price) ?></td>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><?= $f->asCurrency($item->total) ?></td>
		</tr>
		<?php endforeach ?>
	</tbody>
	<tfoot>
		<?php foreach ($order->orderPrices as $op): ?>
		<tr>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;" colspan="3"><b><?= $op->title ?>:</b></td>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><?= $f->asCurrency($op->value) ?></td>
		</tr>
		<?php endforeach ?>
	</tfoot>
</table>