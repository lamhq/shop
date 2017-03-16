<?php
/* @var $this \yii\web\View */
/* @var $model shop\models\Product */
$images = $model->productImages;
\yii\jquery\magnificpopup\MagnificPopupAsset::register($this);
?>
<?php if ($images): ?>
	<ul class="thumbnails">
	<?php foreach ($images as $k => $item): ?>
	<?php
	if ($k==0) {
		$w = $h = 228;
	} else {
		$w = $h = 74;
	};
	$class = $k==0 ? '' : 'image-additional';
	?>
		<li class="<?= $class ?>"><a href="<?= $item->getImageUrl() ?>" class="thumbnail">
			<img src="<?= $item->getImageUrl($w, $h) ?>" alt="" />
		</a></li>
	<?php endforeach ?>
	</ul>
<?php endif ?>
