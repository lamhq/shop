<?php
use yii\helpers\Html;
$f = Yii::$app->formatter;
$name = Html::getInputName($model, 'items');
?>
<?= Html::hiddenInput($name, '') ?>

<?php if ($model->hasErrors('items')): ?>
<?= Html::error($model, 'items',['tag'=>'p', 'class'=>'error-message']) ?>
<?php endif ?>

<div class="table-responsive">
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>Product</th>
				<th>Quantity</th>
				<th>Unit Price</th>
				<th>Total</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php if ($model->items): ?>
			<?php foreach ($model->items as $k => $item): ?>
			<tr>
				<td>
					<?= $item->name ?>
				</td>
				<td>
					<?= Html::textInput("{$name}[$k][quantity]", $item->quantity, ['class'=>'form-control quantity']) ?>
					<?= Html::hiddenInput("{$name}[$k][product_id]", $item->product_id) ?>
					<?= Html::hiddenInput("{$name}[$k][name]", $item->name) ?>
					<?= Html::hiddenInput("{$name}[$k][price]", $item->price) ?>
					<?= Html::hiddenInput("{$name}[$k][total]", $item->total) ?>
				</td>
				<td><?= $f->asCurrency($item->price) ?></td>
				<td><?= $f->asCurrency($item->total) ?></td>
				<td>
					<button type="button" title="Remove" class="btn btn-danger btn-remove-product"><i class="fa fa-minus-circle"></i></button>
				</td>
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
	<legend>Add Product</legend>
	<input type="hidden" id="input-product_id" />
	<div class="form-group">
		<label for="" class="control-label col-sm-2">Choose Product</label>
		<div class="col-sm-10">
			<input type="text" id="input-product" class="form-control"/>
		</div>
	</div>
	<div class="form-group">
		<label for="" class="control-label col-sm-2">Quantity</label>
		<div class="col-sm-10">
			<input type="text" value="1" id="input-quantity" class="form-control"/>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-10 col-sm-offset-2">
			<button class="btn btn-primary" type="button" id="btnAddProduct">
				<i class="fa fa-plus-circle"></i> Add Product
			</button>
		</div>
	</div>
</fieldset>
