<?php
/* @var $this \yii\web\View */
/* @var $model shop\models\Order */

use yii\helpers\Html;

$f = Yii::$app->formatter;
$title = Yii::t('shop', 'Order Information');
$this->title = Yii::$app->helper->getPageTitle($title);
$this->params['breadcrumbs'][] = [
	'label' => Yii::t('app', 'My Dashboard'),
	'url' => ['account/dashboard'],
];
$this->params['breadcrumbs'][] = [
	'label' => Yii::t('shop', 'Order History'),
	'url' => ['order/index'],
];
$this->params['breadcrumbs'][] = $title;
?>
<h1><?= $title ?></h1>

<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th colspan="2"><?= Yii::t('shop', 'Order Details') ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<b><?= Yii::t('shop', 'Order ID') ?>:</b> #<?= $model->id; ?><br />
				<b><?= Yii::t('shop', 'Create Time') ?>:</b> <?= $f->asDate($model->created_at) ?><br />
				<b><?= Yii::t('shop', 'Payment Method') ?>:</b> <?= $model->payment_method; ?><br />				
			</td>
			<td>
				<b><?= Yii::t('shop', 'Name') ?>:</b> <?= $model->name; ?><br />
				<?php if ($model->email): ?>
				<b><?= Yii::t('shop', 'Email') ?>:</b> <?= $model->email; ?><br />
				<?php endif ?>
				<b><?= Yii::t('shop', 'Telephone') ?>:</b> <?= $model->telephone; ?><br />
			</td>
		</tr>
	</tbody>
</table>

<?php if ($model->comment): ?>
<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th><?= Yii::t('shop', 'Comment') ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<?= $model->comment; ?>
			</td>
		</tr>
	</tbody>
</table>
<?php endif ?>

<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th><?= Yii::t('shop', 'Shipping Detail') ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<b><?= Yii::t('shop', 'Name') ?>:</b> <?= $model->shipping_name ?><br/>
				<b><?= Yii::t('shop', 'City') ?>:</b> <?= $model->shippingCity->name ?><br/>
				<b><?= Yii::t('shop', 'District') ?>:</b> <?= $model->shippingDistrict ? $model->shippingDistrict->name : '' ?><br/>
				<b><?= Yii::t('shop', 'Ward') ?>:</b> <?= $model->shippingWard ? $model->shippingWard->name : '' ?><br/>
				<b><?= Yii::t('shop', 'Address') ?>:</b> <?= $model->shipping_address ?>
			</td>
		</tr>
	</tbody>
</table>

<div class="table-responsive">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th><?= Yii::t('shop', 'Product') ?></th>
				<th><?= Yii::t('shop', 'Quantity') ?></th>
				<th><?= Yii::t('shop', 'Unit Price') ?></th>
				<th><?= Yii::t('shop', 'Total') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($model->orderProducts as $item): ?>
			<tr>
				<td><?= $item->product->name; ?></td>
				<td class="text-right"><?= $item->quantity; ?></td>
				<td><?= $f->asCurrency($item->price) ?></td>
				<td><?= $f->asCurrency($item->total) ?></td>
			</tr>
			<?php endforeach ?>
		</tbody>
		<tfoot>
			<?php foreach ($model->orderPrices as $op): ?>
			<tr>
				<td colspan="3" class="text-right"><b><?= $op->title ?>:</b></td>
				<td><?= $f->asCurrency($op->value) ?></td>
			</tr>
			<?php endforeach ?>
		</tfoot>
	</table>
</div>

<h3><?= Yii::t('shop', 'Order History') ?></h3>

<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th><?= Yii::t('shop', 'Create Time') ?></th>
			<th><?= Yii::t('shop', 'Status') ?></th>
			<th><?= Yii::t('shop', 'Comment') ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($model->orderHistories as $oh): ?>
		<tr>
			<td><?= $f->asDate($oh->created_at) ?></td>
			<td><?= $model->getStatusText($oh->status) ?></td>
			<td><?= $oh->comment ?></td>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>