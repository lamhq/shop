<?php
use yii\helpers\Html;
?>
<div class="list-group">
	<?= Html::a(Yii::t('app', 'My Dashboard'), ['account/dashboard'], ['class'=>'list-group-item']) ?>
	<?= Html::a(Yii::t('app', 'Edit Account'), ['account/edit'], ['class'=>'list-group-item']) ?>
	<?= Html::a(Yii::t('shop', 'Order History'), ['order/index'], ['class'=>'list-group-item']) ?>
</div>
