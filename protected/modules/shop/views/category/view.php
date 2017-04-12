<?php
/* @var $this \yii\web\View */
/* @var $model shop\models\Category */
/* @var $dataProvider yii\data\DataProviderInterface */
use yii\helpers\Html;
use app\helpers\AppHelper;
use shop\widgets\ProductList;
use shop\widgets\CategoryNavigation;

$this->title = AppHelper::getPageTitle($model->name);
$this->params['breadcrumbs'][] = $model->name;
$image = $model->getImageUrl();
?>
<div class="row">
	<aside class="col-sm-3">
		<?= CategoryNavigation::widget(); ?>
	</aside>
	<div class="col-md-9">
		<h2><?= Html::encode($model->name) ?></h2>
		<p class="cat-desc"><?= $model->description ?></p>
		
		<?php if ($image): ?>
		<p><?= Html::img($image, ['class'=>'img-thumbnail']) ?></p>
		<?php endif ?>
		
		<?= ProductList::widget([
			'dataProvider' => $dataProvider,
			'itemView' => '@shop/widgets/views/productThumb',
			'toolbarView' => '@shop/widgets/views/productListToolbar',
		]); ?>
	</div>
</div>