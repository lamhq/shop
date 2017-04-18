<?php
/* @var $this \yii\web\View */
/* @var $model shop\models\Product */
/* @var $cart shop\models\AddToCartForm */
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use shop\models\Product;

$this->title = Yii::$app->helper->getPageTitle($model->name);
$this->params['breadcrumbs'][] = $model->name;
$f = Yii::$app->formatter;
$stockStatusText = ArrayHelper::getValue($model->getStockStatusOptions(), $model->stock_status);
$this->registerJs('app.setupProductDetailPage();');
?>
<div class="row">
	<div class="col-md-8">
		<!-- product images -->
		<?= $this->render('_images', ['model'=>$model]) ?>

		<!-- product tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab-description" data-toggle="tab"><?= Yii::t('shop', 'Description') ?></a></li>
			<li><a href="#tab-review" data-toggle="tab"><?= Yii::t('app', 'Reviews ({0})', [12]) ?></a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="tab-description">
				<?= $model->description ?>
			</div>
			<div class="tab-pane" id="tab-review">
				<form class="form-horizontal" id="form-review">
					<div id="review"><p>There are no reviews for this product.</p></div>
						<h2>Write a review</h2>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<!-- product detail -->
		<h1><?= $model->name ?></h1>
		<p class="<?= $model->stock_status==Product::STATUS_OUT_OF_STOCK ? 'text-danger' : 'text-success' ?>"><strong><?= $stockStatusText ?></strong></p>
		<p><?= Html::encode($model->short_description) ?></p>
		<h2><?= $f->asCurrency($model->price) ?></h2>

		<div class="cart-section">
			<?= $this->render('/cart/_cartForm', ['model'=>$cart]) ?>
		</div>
	</div>
</div>