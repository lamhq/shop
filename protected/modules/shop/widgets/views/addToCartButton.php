<?php
$this->registerJs('app.setupAddToCartButton();');
?>
<button type="button" class="btn btn-primary btn-cart" data-product="<?= $product->id ?>">
	<i class="fa fa-shopping-cart"></i>
	<?= $csrfToken ?>
	<span class="hidden-xs"><?= Yii::t('shop', 'Add to Cart') ?></span>
</button>