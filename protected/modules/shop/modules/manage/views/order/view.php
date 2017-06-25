<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model shop\modules\manage\models\Order */

$this->title = Yii::t('shop', 'View Order #{0}', $model->id);
$this->params['breadcrumbs'][] = [
	'label' => Yii::t('shop', 'Orders'),
	'url' => ['index']
];
$this->params['breadcrumbs'][] = $this->title;
$f = Yii::$app->formatter;
?>
<?php $this->beginBlock('buttons') ?>
	<a href="<?= Url::to(['index']) ?>" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="<?= Yii::t('backend', 'Cancel') ?>"><i class="fa fa-reply"></i></a>
<?php $this->endBlock() ?>

<!-- Order Detail -->
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-shopping-cart"></i> Order Details</h3>
			</div>
			<table class="table">
				<tbody>
					<tr>
						<td style="width: 1%;"><button data-toggle="tooltip" title="" class="btn btn-info btn-xs" data-original-title="Date Added"><i class="fa fa-calendar fa-fw"></i></button></td>
						<td><?= $f->asDate($model->created_at) ?></td>
					</tr>
					<tr>
						<td><button data-toggle="tooltip" title="" class="btn btn-info btn-xs" data-original-title="Payment Method"><i class="fa fa-credit-card fa-fw"></i></button></td>
						<td><?= $model->payment_method ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-shopping-cart"></i> Customer Details</h3>
			</div>
			<table class="table">
			<tbody>
			<tr>
				<td style="width: 1%;">
					<button data-toggle="tooltip" title="" class="btn btn-info btn-xs" data-original-title="Customer"><i class="fa fa-user fa-fw"></i></button>
				</td>
				<td>
					<?php if ($model->customer): ?>
						<?= Html::a($model->customer->name, ['customer/update', 'id'=>$model->customer->id]) ?>
					<?php else: ?>
						<?= $model->name ?>
					<?php endif ?>
				</td>
			</tr>
			<tr>
				<td>
					<button data-toggle="tooltip" title="" class="btn btn-info btn-xs" data-original-title="E-Mail"><i class="fa fa-envelope-o fa-fw"></i></button>
				</td>
				<td><a href="mailto:mailer@local.app"><?= $model->email ?></a></td>
			</tr>
			<tr>
				<td>
					<button data-toggle="tooltip" title="" class="btn btn-info btn-xs" data-original-title="Telephone"><i class="fa fa-phone fa-fw"></i></button>
				</td>
				<td><?= $model->telephone ?></td>
			</tr>
			</tbody>
			</table>
		</div>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-info-circle"></i>
			<?= Yii::t('shop', 'Order #{0}', $model->id) ?>
		</h3>
	</div>
	<div class="panel-body">
		<!-- Shipping Address -->
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th><?= Yii::t('shop', 'Shipping Address') ?></th>
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

		<!-- Products -->
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
						<td><?= Html::a($item->product->name, ['product/update', 'id'=>$item->product->id]); ?></td>
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

		<!-- Order's Comment -->
		<?php if ($model->comment): ?>
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th><?= Yii::t('shop', 'Customer Comment') ?></th>
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
	</div>
</div>

<!-- History -->
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-comment-o"></i> <?= Yii::t('shop', 'Order History') ?></h3>
	</div>
	<div class="panel-body">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th><?= Yii::t('shop', 'Create Time') ?></th>
					<th><?= Yii::t('shop', 'Status') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($model->orderHistories as $oh): ?>
				<tr>
					<td><?= $f->asDate($oh->created_at) ?></td>
					<td><?= $model->getStatusText($oh->status) ?></td>
				</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>
