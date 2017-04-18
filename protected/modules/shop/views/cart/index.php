<?php
/* @var $this \yii\web\View */
/* @var $model shop\models\Order */
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;

$f = Yii::$app->formatter;
$title = Yii::t('shop', 'Shopping Cart');
$itemCollection = $model->itemCollection;
$this->title = Yii::$app->helper->getPageTitle($title);
$this->params['breadcrumbs'][] = $title;
$this->registerJs('app.setupCartPage();');
?>
<h1><?= $title ?></h1>

<?php if ($itemCollection->hasItems()): ?>
	<?php $form = ActiveForm::begin([
		'id' => 'cartForm',
		'action' => ['/shop/cart/update'],
		'enableClientValidation' => true,
		'validateOnSubmit' => true,
	]); ?>
	<div class="table-responsive">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th><?= Yii::t('shop', 'Image') ?></th>
					<th><?= Yii::t('shop', 'Product Name') ?></th>
					<th><?= Yii::t('shop', 'Quantity') ?></th>
					<th><?= Yii::t('shop', 'Unit Price') ?></th>
					<th><?= Yii::t('shop', 'Total') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($itemCollection->getItems() as $item): ?>
				<?php $product = $item->product ?>
				<tr>
					<td class="text-center"><?= Html::img($product->getImageUrl(47, 47), ['class'=>'img-thumbnail']) ?></td>
					<td><?= Html::a($product->name, $product->getUrl()) ?></td>
					<td>
						<div class="input-group btn-block" style="max-width: 200px;">
							<?= Html::activeTextInput($item, "quantity", [
								'class'=>'form-control',
								'size'=>1,
								'name'=>"quantity[{$item->id}]"
							]) ?>
							<span class="input-group-btn">
                   				<button type="submit" data-toggle="tooltip" title="<?= Yii::t('shop', 'Update') ?>" class="btn btn-primary">
                   					<i class="fa fa-refresh"></i>
                   				</button>
                    			<button type="button" data-toggle="tooltip" title="<?= Yii::t('shop', 'Remove') ?>" class="btn btn-danger btn-remove" data-item="<?= $item->id ?>">
                    				<i class="fa fa-times-circle"></i>
                    			</button>
                   		 	</span>
						</div>
					</td>
					<td><?= $f->asCurrency($item->getUnitPrice()) ?></td>
					<td><?= $f->asCurrency($item->getTotal()) ?></td>
				</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
	<?php ActiveForm::end(); ?>

	<div class="row">
		<div class="col-sm-4 col-sm-offset-8">
			<table class="table table-bordered">
				<tbody>
				<?php foreach ($model->getPrices() as $item): ?>
					<tr>
						<td class="text-right"><strong><?= $item['title'] ?></strong></td>
						<td class="text-right"><?= $f->asCurrency($item['value']) ?></td>
					</tr>
				<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="buttons clearfix">
		<div class="pull-left"><a href="<?= Yii::$app->homeUrl ?>" class="btn btn-default"><?= Yii::t('shop', 'Continue Shopping') ?></a></div>
		<div class="pull-right"><button class="btn btn-primary" type="button"><?= Yii::t('shop', 'Place Order') ?></button></div>
	</div>
<?php else: ?>
	<p><?= Yii::t('shop', 'Your shopping cart is empty!') ?></p>
	<div class="buttons clearfix">
		<div class="pull-right"><a href="<?= Yii::$app->homeUrl ?>" class="btn btn-primary"><?= Yii::t('shop', 'Continue') ?></a></div>
	</div>
<?php endif ?>