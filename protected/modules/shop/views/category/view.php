<?php
/* @var $this \yii\web\View */
/* @var $model shop\models\Category */
/* @var $dataProvider yii\data\DataProviderInterface */
use yii\helpers\Html;

$this->title = Yii::$app->helper->getPageTitle($model->name);
$image = $model->getImageUrl();
?>
<div class="row">
	<aside class="col-sm-4">
		<?= \shop\widgets\CategorySidebar::widget(); ?>
	</aside>
	<div class="col-sm-8">
		<h2><?= Html::encode($model->name) ?></h2>
		<p class="cat-desc"><?= $model->description ?></p>
		
		<?php if ($image): ?>
		<p><?= Html::img($image, ['class'=>'img-thumbnail']) ?></p>
		<?php endif ?>
		
		<?= \shop\widgets\ProductList::widget([
			'dataProvider' => $dataProvider,
			'itemView' => '@shop/widgets/views/productThumb',
			'toolbarView' => '@shop/widgets/views/productListToolbar',
		]); ?>
	</div>
</div>