<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use shop\models\CheckoutForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
$addresses = $model->customer->getAddressOptions();
$cname = Html::getInputName($model, 'shippingAddressType');
$shipping = $model->shippingAddress;
?>
<?php $form = ActiveForm::begin(['id' => 'shippingForm']); ?>
	<?php if ($addresses): ?>
	<div class="radio">
		<label>
			<?= Html::radio($cname, 
			$model->shippingAddressType==CheckoutForm::ADDRESS_EXISTING, 
			['class'=>'address-type', 'value'=>CheckoutForm::ADDRESS_EXISTING ]) ?> 
			<?= Yii::t('shop', 'I want to use an existing address') ?>
		</label>
	</div>
	<div id="payment-existing">
		<?= Html::activeDropDownList($model, 'shippingAddressId', $addresses, 
		['class'=>'form-control', 'prompt'=>Yii::t('shop','-- Please select --')]) ?>
	</div>
	<div class="radio">
		<label>
			<?= Html::radio($cname, 
			$model->shippingAddressType==CheckoutForm::ADDRESS_NEW, 
			['class'=>'address-type', 'value'=>CheckoutForm::ADDRESS_NEW]) ?> 
			<?= Yii::t('shop', 'I want to use a new address') ?>
		</label>
	</div>
	<?php endif ?>
	<div id="payment-new">
		<?php echo $form->field($shipping, 'name') ?>
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
	</div>
	<div class="buttons">
		<div class="pull-right">
			<button type="submit" data-loading-text="Loading..." class="btn btn-primary">Continue</button>
		</div>
	</div>
<?php ActiveForm::end(); ?>
