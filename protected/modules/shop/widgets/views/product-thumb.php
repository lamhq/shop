<?php
/* @var $this \yii\web\View */
/* @var $model shop\models\Product */
/* @var $key mixed */
/* @var $index integer, the zero-based index  */
/* @var $widget shop\widgets\ProductList */
use yii\helpers\Html;
use yii\helpers\StringHelper;
use shop\widgets\AddToCartButton;

$f = Yii::$app->formatter;
?>
<div class="product-thumb">
	<div class="image">
		<a href="<?= $model->getUrl() ?>">
			<?= Html::img($model->getImageUrl(220, 258), ['class'=>'img-responsive']) ?>
		</a>
	</div>
	<div>
		<div class="caption">
			<h4><a href="<?= $model->getUrl() ?>"><?= $model->name ?></a></h4>
			<div class="desc"><?= Html::encode(StringHelper::truncate($model->short_description, 50)) ?></div>
			<p class="price"><?= $f->asCurrency($model->price) ?></p>
		</div>
		<div class="button-group">
			<?= AddToCartButton::widget(['product'=>$model]) ?>
		</div>
	</div>
</div>
