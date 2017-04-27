<?php

/* @var $this yii\web\View */
/* @var $order shop\models\Order */
$f = Yii::$app->format;
?>
<p>Thank you for your interest in <?= Yii::$app->name ?> products. Your order has been received and will be processed once payment has been confirmed.</p>

<?php if ($customer_id) { ?>
<p>To view your order click on the link below:</p>
<p><a href="<?= $link; ?>"><?= $link; ?></a></p>
<?php endif ?>

<table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
	<thead>
		<tr>
			<td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;" colspan="2">Order Details</td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">
				<b>Order ID:</b> <?= $order->id; ?><br />
				<b>Date Added:</b> <?= $f->asDate($order->create_time) ?><br />
				<b><?= $text_payment_method; ?></b> <?= $payment_method; ?><br />
				<?php if ($shipping_method) { ?>
				<b><?= $text_shipping_method; ?></b> <?= $shipping_method; ?>
				<?php } ?></td>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><b><?= $text_email; ?></b> <?= $email; ?><br />
				<b><?= $text_telephone; ?></b> <?= $telephone; ?><br />
				<b><?= $text_ip; ?></b> <?= $ip; ?><br />
				<b><?= $text_order_status; ?></b> <?= $order_status; ?><br /></td>
		</tr>
	</tbody>
</table>
<?php if ($comment) { ?>
<table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
	<thead>
		<tr>
			<td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;"><?= $text_instruction; ?></td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?= $comment; ?></td>
		</tr>
	</tbody>
</table>
<?php } ?>
<table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
	<thead>
		<tr>
			<td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;"><?= $text_payment_address; ?></td>
			<?php if ($shipping_address) { ?>
			<td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;"><?= $text_shipping_address; ?></td>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?= $payment_address; ?></td>
			<?php if ($shipping_address) { ?>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?= $shipping_address; ?></td>
			<?php } ?>
		</tr>
	</tbody>
</table>
<table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
	<thead>
		<tr>
			<td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;"><?= $text_product; ?></td>
			<td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;"><?= $text_model; ?></td>
			<td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: right; padding: 7px; color: #222222;"><?= $text_quantity; ?></td>
			<td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: right; padding: 7px; color: #222222;"><?= $text_price; ?></td>
			<td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: right; padding: 7px; color: #222222;"><?= $text_total; ?></td>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($products as $product) { ?>
		<tr>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?= $product['name']; ?>
				<?php foreach ($product['option'] as $option) { ?>
				<br />
				&nbsp;<small> - <?= $option['name']; ?>: <?= $option['value']; ?></small>
				<?php } ?></td>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?= $product['model']; ?></td>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><?= $product['quantity']; ?></td>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><?= $product['price']; ?></td>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><?= $product['total']; ?></td>
		</tr>
		<?php } ?>
		<?php foreach ($vouchers as $voucher) { ?>
		<tr>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?= $voucher['description']; ?></td>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"></td>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;">1</td>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><?= $voucher['amount']; ?></td>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><?= $voucher['amount']; ?></td>
		</tr>
		<?php } ?>
	</tbody>
	<tfoot>
		<?php foreach ($totals as $total) { ?>
		<tr>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;" colspan="4"><b><?= $total['title']; ?>:</b></td>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><?= $total['text']; ?></td>
		</tr>
		<?php } ?>
	</tfoot>
</table>
<p><?= $text_footer; ?></p>
