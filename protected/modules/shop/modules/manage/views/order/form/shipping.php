<?php
?>
<?php if ($model->customer_id): ?>
	<?php $addresses = $model->customer->getAddressOptions(); ?>
	<?php if ($addresses): ?>
	<?= $form->field($model, 'shippingAddressId')->dropdownList($addresses, ['prompt'=>'--- None ---']) ?>
	<?php endif ?>
<?php endif ?>

<?php echo $form->field($model, 'shipping_city_id')
	->dropdownList(\shop\models\City::getCityOptions(), [
		'prompt'=>Yii::t('app','-- Please select --'), 
		'class'=>'selectpicker form-control city',
	]) ?>
<?php echo $form->field($model, 'shipping_district_id')
	->dropdownList(\shop\models\District::getDistrictOptions($model->shipping_city_id), [
		'prompt'=>Yii::t('app','-- Please select --'), 
		'class'=>'selectpicker form-control district',
]) ?>
<?php echo $form->field($model, 'shipping_ward_id')
	->dropdownList(\shop\models\Ward::getWardOptions($model->shipping_district_id), [
		'prompt'=>Yii::t('app','-- Please select --'), 
		'class'=>'selectpicker form-control ward',
	]) ?>
<?php echo $form->field($model, 'shipping_address') ?>