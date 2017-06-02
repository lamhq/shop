<?php
/* @var $this \yii\web\View */
/* @var $model shop\models\Category */
/* @var $dataProvider yii\data\DataProviderInterface */
use yii\helpers\Html;

$image = $model->getImageUrl();
?>
<div class="row">
	<aside class="col-sm-3 hidden-xs">
		<?= \shop\widgets\CategorySidebar::widget(); ?>
	</aside>
	<div class="col-sm-9">
		<h2><?= Html::encode($model->name) ?></h2>
		<p class="cat-desc"><?= $model->description ?></p>
		
		<?php if ($image): ?>
		<p><?= Html::img($image, ['class'=>'img-thumbnail']) ?></p>
		<?php endif ?>
		
		<?= \shop\widgets\ProductList::widget([
			'dataProvider' => $dataProvider,
			'itemView' => '@shop/widgets/views/productThumb',
			'itemOptions' => ['class'=>'product-layout product-grid col-lg-4 col-md-4 col-sm-6 col-xs-12'],
			'toolbarView' => '@shop/widgets/views/productListToolbar',
			'beforeItem' => function ($product, $key, $index, $widget) use ($model) {
				$product->path = $model->path.'/'.$product->slug;
			}
		]); ?>
	</div>
</div>