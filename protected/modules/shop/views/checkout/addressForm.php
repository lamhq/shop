<?php
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model shop\models\Address */
?>
<?php echo $form->field($model, 'name') ?>
<?php echo $form->field($model, 'city_id')
	->dropdownList(\shop\models\City::getCityOptions(), [
		'prompt'=>Yii::t('shop','-- Please select --'), 
		'class'=>'select2 city',
		'style'=>'width: 100%',
	]) ?>
<?php echo $form->field($model, 'district_id')
	->dropdownList(\shop\models\District::getDistrictOptions($model->city_id), [
		'prompt'=>Yii::t('shop','-- Please select --'), 
		'class'=>'select2 district',
		'style'=>'width: 100%',
]) ?>
<?php echo $form->field($model, 'ward_id')
	->dropdownList(\shop\models\Ward::getWardOptions($model->district_id), [
		'prompt'=>Yii::t('shop','-- Please select --'), 
		'class'=>'select2 ward',
		'style'=>'width: 100%',
	]) ?>
<?php echo $form->field($model, 'address') ?>
