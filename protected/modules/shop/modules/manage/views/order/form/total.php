<?php
$f = Yii::$app->formatter;
?>
<div class="table-responsive">
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>Product</th>
				<th class="text-right">Quantity</th>
				<th class="text-right">Unit Price</th>
				<th class="text-right">Total</th>
			</tr>
		</thead>
		<tbody>
		<?php if ($model->items): ?>
			<?php foreach ($model->items as $k => $item): ?>
			<tr>
				<td>
					<?= $item->name ?>
				</td>
				<td class="text-right">
					<?= $item->quantity ?>
				</td>
				<td class="text-right"><?= $f->asCurrency($item->price) ?></td>
				<td class="text-right"><?= $f->asCurrency($item->total) ?></td>
			</tr>
			<?php endforeach ?>
			<?php foreach ($model->collectPrices() as $item): ?>
				<tr>
					<td class="text-right" colspan="3"><strong><?= $item['title'] ?></strong></td>
					<td class="text-right"><?= $f->asCurrency($item['value']) ?></td>
				</tr>
			<?php endforeach ?>
		<?php else: ?>
			<tr>
				<td colspan="5" class="text-center">No results!</td>
			</tr>
		<?php endif ?>
		</tbody>
	</table>
</div>

<fieldset>
	<legend>Order Details</legend>
	<?= $form->field($model, 'comment')->textArea() ?>
	<?= $form->field($model, 'status')->dropdownList($model->getStatusOptions()) ?>
</fieldset>
