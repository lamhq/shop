<?php
/* @var $model shop\models\Review */
?>
<div class="review">
	<p class="rating"><?= \shop\widgets\Rating::widget([ 'value'=>$model->rating ]) ?></p>
	<p>
		<?= Yii::$app->formatter->asDate($model->created_at, 'php:d/m/Y') ?>
		<em><?= Yii::t('shop', 'by') ?></em>
		<?= $model->author ?>
	</p>
	<p><?= $model->text ?></p>
</div>
