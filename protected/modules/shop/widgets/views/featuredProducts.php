<?php
use shop\widgets\ProductList;
?>
<h3><?= Yii::t('shop', 'Featured Products') ?></h3>
<?= ProductList::widget([
	'dataProvider'=>$dataProvider,
	'itemView' => 'productThumb',
	'itemOptions' => ['class'=>'product-layout col-lg-3 col-md-3 col-sm-6 col-xs-12'],
]); ?>
