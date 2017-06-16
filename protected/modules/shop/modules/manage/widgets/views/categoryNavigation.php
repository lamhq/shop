<?php

/* @var $this yii\web\View */
/* @var $items array */
use yii\helpers\Html;
?>
<div class="list-group">
	<?php foreach ($items as $item): ?>
		<?= Html::a($item['label'], $item['url'], ['class'=>'list-group-item']) ?>
	<?php endforeach ?>
</div>
