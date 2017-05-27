<?php
use yii\web\View;

\lamhq\yii2\asset\OwlCarousel2::register($this);
$this->registerJs('app.setupSlideshow();', View::POS_READY);
?>
<div class="owl-carousel owl-theme">
	<?php foreach ($model->slideshowImages as $image): ?>
	<div class="item">
	<?php if ($image->link): ?>
		<a href="<?= $image->link ?>"><img src="<?= $image->getImageUrl() ?>" alt="<?= $image->title ?>" class="img-responsive" /></a>
	<?php else: ?>
		<img src="<?= $image->getImageUrl() ?>" alt="<?= $image->title ?>" class="img-responsive" />
	<?php endif ?>
	</div>
	<?php endforeach ?>
</div>