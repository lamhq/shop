<?php

/* @var $this yii\web\View */
/* @var $items array */
use yii\widgets\Menu;
?>
<?= Menu::widget([
	'items'=>$items,
	'options' => ['class'=>'category-nav list-group'],
	'itemOptions' => ['class'=>'list-group-item'],
	'encodeLabels'=>false,
]) ?>
