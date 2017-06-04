<?php
$this->registerJs('app.setupAddToCartButton();');
?>
<button type="button" class="btn-cart" data-product="<?= $product->id ?>" data-loading-text="<?= Yii::t('app', 'Loading...') ?>">
	<i class="fa fa-shopping-cart fa-cs"></i>
	<?= $csrfToken ?>
	<span><?= Yii::t('shop', 'Add to Cart') ?></span>
</button>