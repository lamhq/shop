<?php
/* @var $text string */
use yii\helpers\Url;
use yii\helpers\Html;
?>
<form id="searchForm" action="<?= Url::to(['/shop/product/search']) ?>" method="GET">
	<div class="input-group">
		<?= Html::textInput('text', $text, [
			'placeholder'=>Yii::t('shop', 'Search'),
			'class'=>'form-control input-lg'
		]) ?>
		<span class="input-group-btn">
			<button type="submit" class="btn btn-default btn-lg"><i class="fa fa-search"></i></button>
		</span>
	</div>
</form>