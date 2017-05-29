<?php
use yii\web\View;

\lamhq\yii2\asset\OwlCarousel2::register($this);
$script = <<<EOT
$(".slideshow").owlCarousel({
	items: 1,
	nav: true,
	navText: ['<i class="fa fa-chevron-left fa-3x"></i>', '<i class="fa fa-chevron-right fa-3x"></i>'],
	dots: true,
	loop: true
});
EOT;
$this->registerJs($script, View::POS_READY);
?>
<div class="slideshow owl-carousel owl-theme">
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