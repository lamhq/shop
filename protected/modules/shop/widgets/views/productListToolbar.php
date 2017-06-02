<?php
/* @var $this \yii\web\View */
/* @var $widget shop\widgets\ProductList */
use yii\helpers\Html;
use yii\helpers\StringHelper;

$f = Yii::$app->formatter;
?>
<div class="row product-toolbar">
	<div class="col-md-4 col-xs-6">
		<div class="form-group input-group input-group-sm">
			<label class="input-group-addon" for="input-sort"><?= Yii::t('shop', 'Sort By') ?>:</label>
			<select name="sort" id="input-sort" class="form-control">
				<?php foreach($widget->getSortDropdownItems() as $item): ?>
				<?= Html::tag('option', $item['label'], [
					'selected' => $item['selected'],
					'value' => $item['url']
				]) ?>
				<?php endforeach ?>
			</select>
		</div>	
	</div>	
	<div class="col-md-4 col-xs-6">
		<div class="form-group input-group input-group-sm">
			<label class="input-group-addon" for="input-limit"><?= Yii::t('shop', 'Show') ?>:</label>
			<select name="limit" id="input-limit" class="form-control">
				<?php foreach($widget->getLimitDropdownItems() as $item): ?>
				<?= Html::tag('option', $item['label'], [
					'selected' => $item['selected'],
					'value' => $item['url']
				]) ?>
				<?php endforeach ?>
			</select>
		</div>	
	</div>	
</div>