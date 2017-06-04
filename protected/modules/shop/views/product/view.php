<?php
/* @var $this \yii\web\View */
/* @var $model shop\models\Product */
/* @var $cart shop\models\AddToCartForm */
use yii\helpers\Html;

$f = Yii::$app->formatter;
$this->registerJs('app.setupProductDetailPage();');
?>
<div class="row">
	<div class="col-sm-4 col-sm-push-8">
		<!-- product detail -->
		<h1><?= $model->name ?></h1>
		
		<p class="<?= $model->isOutOfStock() ? 'text-danger' : 'text-success' ?>"><strong><?= $model->getStockStatusText() ?></strong></p>

		<h2><?= $f->asCurrency($model->price) ?></h2>

		<div id="cartForm">
			<?= $this->render('_cartForm', ['model'=>$cart]) ?>
		</div>
		<div class="rating">
			<p>
				<?= \shop\widgets\Rating::widget([ 'value'=>$model->rating ]) ?>
				<a href="javascript:void(0)" onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;"><?= Yii::t('shop', '{0} reviews', count($model->approvedReviews)) ?></a>
			</p>
			<hr>
			<!-- AddThis Button BEGIN -->
			<div class="addthis_toolbox addthis_default_style" data-url="<?= $model->getUrl() ?>">
				<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a> 
				<a class="addthis_button_tweet"></a> 
				<a class="addthis_button_pinterest_pinit"></a> 
				<a class="addthis_counter addthis_pill_style"></a>
			</div>
			<!-- AddThis Button END -->
		</div>		
	</div>
	<div class="col-sm-8 col-sm-pull-4">
		<!-- product images -->
		<?= $this->render('_images', ['model'=>$model]) ?>

		<!-- product tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab-description" data-toggle="tab"><?= Yii::t('shop', 'Description') ?></a></li>
			<li><a href="#tab-review" data-toggle="tab"><?= Yii::t('shop', 'Reviews ({0})', count($model->approvedReviews)) ?></a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="tab-description">
				<?= $model->description ?>
			</div>
			<div class="tab-pane" id="tab-review">
				<div id="reviews" data-product-id="<?= $model->id ?>"></div>
				<div id="reviewForm" data-product-id="<?= $model->id ?>"></div>
			</div>
		</div>
	</div>
</div>