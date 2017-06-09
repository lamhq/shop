<?php
/* @var $this \yii\web\View */
/* @var $model shop\models\Order */
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;

$f = Yii::$app->formatter;
$itemCollection = $model->itemCollection;
$title = Yii::t('shop', 'Shopping Cart');
$this->title = Yii::$app->helper->getPageTitle($title);
$this->params['breadcrumbs'][] = $title;
$this->registerJs('app.setupCartPage();');
app\assets\BootstrapSelect::register($this);
?>
<h1><?= $title ?></h1>

<?php if ($itemCollection->hasItems()): ?>
	<?php $form = ActiveForm::begin([
		'id' => 'cartForm',
		'action' => ['/shop/cart/update'],
		'enableClientScript' => false,
	]); ?>
	<div class="table-responsive">
		<table class="table table-bordered cart-table">
			<thead>
				<tr>
					<th><?= Yii::t('shop', 'Image') ?></th>
					<th><?= Yii::t('shop', 'Product') ?></th>
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
					<td>
						<div><?= Html::a($product->name, $product->getUrl()) ?></div>
						<?php if ($product->isOutOfStock()): ?>
							<div>
								<em class="text-danger"><?= Yii::t('shop', 'Out Of Stock') ?></em>
							</div>
						<?php endif ?>
					</td>
					<td>
						<div class="input-group btn-block" style="max-width: 200px;">
							<?= Html::activeTextInput($item, "quantity", [
								'class'=>'form-control',
								'size'=>1,
								'name'=>"quantity[{$item->id}]"
							]) ?>
							<span class="input-group-btn">
								<button type="submit" data-toggle="tooltip" title="<?= Yii::t('app', 'Update') ?>" class="btn btn-primary">
									<i class="fa fa-refresh"></i>
								</button>
								<button type="button" data-toggle="tooltip" title="<?= Yii::t('app', 'Remove') ?>" class="btn btn-danger btn-remove" data-item="<?= $item->id ?>">
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

	<h1><?= Yii::t('shop', 'Checkout') ?></h1>
	<div class="row">
		<div id="shipping-section" class="col-sm-6"></div>
		<div class="col-sm-6">
			<div id="payment-section"></div>
			<div id="review-section"></div>
		</div>
	</div>

<?php else: ?>
	<p><?= Yii::t('shop', 'Your shopping cart is empty!') ?></p>
	<div class="buttons clearfix">
		<div class="pull-right"><a href="<?= Yii::$app->homeUrl ?>" class="btn btn-primary"><?= Yii::t('shop', 'Continue') ?></a></div>
	</div>
<?php endif ?>