<?php
/* @var $this \yii\web\View */
/* @var $model shop\models\Product */
/* @var $key mixed */
/* @var $index integer, the zero-based index  */
/* @var $widget shop\widgets\ProductList */
use yii\helpers\Html;
use yii\helpers\StringHelper;
use shop\widgets\CartButton;

$f = Yii::$app->formatter;
?>
<div class="product-thumb">
	<div class="image">
		<a href="<?= $model->getUrl() ?>">
			<?= Html::img($model->getImageUrl(220, 258), ['class'=>'img-responsive']) ?>
		</a>
	</div>
	<div class="caption">
		<h4><a href="<?= $model->getUrl() ?>"><?= $model->name ?></a></h4>
		<div class="rating"><?= \shop\widgets\Rating::widget([ 'value'=>$model->rating ]) ?></div>
		<p class="price"><?= $f->asCurrency($model->price) ?></p>
	</div>
	<div class="button-group">
		<?= CartButton::widget(['product'=>$model]) ?>
	</div>
</div>
