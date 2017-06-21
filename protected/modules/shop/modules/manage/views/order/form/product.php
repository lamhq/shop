<?php
use yii\helpers\Html;
?>
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
			<?php if ($model->cartItems): ?>
			<?php foreach ($model->cartItems as $k => $item): ?>
			<tr>
				<td>
					<?= $item['name'] ?>
				</td>
				<td>
					<div class="input-group btn-block" style="max-width: 200px;">
						<input type="text" name="Order[cartItems][<?= $k ?>][quantity]" value="<?= $item['quantity'] ?>" class="form-control">
						<span class="input-group-btn">
							<button type="button" data-toggle="tooltip" title="" data-loading-text="Loading..." class="btn btn-primary" data-original-title="Refresh"><i class="fa fa-refresh"></i></button>
						</span>
					</div>
				</td>
				<td></td>
				<td></td>
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
