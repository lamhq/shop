<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
$signup = $model->signupForm;
$shipping = $model->shippingAddress;
?>
<?php $form = ActiveForm::begin(['id' => 'shippingForm']); ?>
<div class="row">
	<div class="col-sm-6">
		<fieldset>
			<legend><?= Yii::t('shop', 'Your Personal Details') ?></legend>
			<?php echo $form->field($model, 'name') ?>
			<?php echo $form->field($model, 'telephone') ?>
			<?php echo $form->field($model, 'email') ?>
			<?php echo $form->field($model, 'register')->checkbox() ?>
		</fieldset>
		<fieldset class="registration-section">
			<legend><?= Yii::t('shop', 'Registration Information') ?></legend>
			<?php echo $form->field($signup, 'password')->passwordInput() ?>
			<?php echo $form->field($signup, 'password_repeat')->passwordInput() ?>
		</fieldset>
	</div>
	<div class="col-sm-6">
		<fieldset>
			<legend><?= Yii::t('shop', 'Your Address') ?></legend>
			<?php echo $form->field($shipping, 'city')
				->dropdownList(\shop\models\City::getCityOptions(), [
					'prompt'=>Yii::t('shop','-- Please select --'), 
					'class'=>'select2',
					'style'=>'width: 100%',
				]) ?>
			<?php echo $form->field($shipping, 'district')
				->dropdownList(\shop\models\District::getDistrictOptions($shipping->city), [
					'prompt'=>Yii::t('shop','-- Please select --'), 
					'class'=>'select2',
					'style'=>'width: 100%',
			]) ?>
			<?php echo $form->field($shipping, 'ward')
				->dropdownList(\shop\models\Ward::getWardOptions($shipping->district), [
					'prompt'=>Yii::t('shop','-- Please select --'), 
					'class'=>'select2',
					'style'=>'width: 100%',
				]) ?>
			<?php echo $form->field($shipping, 'address') ?>
		</fieldset>
	</div>
</div>
<div class="buttons">
	<div class="pull-right">
		<button type="submit" data-loading-text="Loading..." class="btn btn-primary">Continue</button>
	</div>
</div>
<?php ActiveForm::end(); ?>
