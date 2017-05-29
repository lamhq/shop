<?php
$this->title = Yii::$app->helper->getPageTitle('');
?>
<?= \app\widgets\Slideshow::widget(['slideshowId'=>1]) ?>

<?= shop\widgets\FeaturedProductList::widget([
	'itemView' => '@shop/widgets/views/productThumb',
	'itemOptions' => ['class'=>'col-md-3'],
]); ?>
