<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use shop\models\CheckoutForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
$addresses = $model->customer->getAddressOptions();
$cname = Html::getInputName($model, 'shippingAddressType');
?>
<h3><?= Yii::t('shop', 'Shipping Detail') ?></h3>

<?php $form = ActiveForm::begin(['id' => 'shippingForm']); ?>
	<?php if ($addresses): ?>
	<div class="radio">
		<label>
			<?= Html::radio($cname, 
			$model->shippingAddressType==CheckoutForm::ADDRESS_TYPE_EXISTING, 
			['class'=>'address-type', 'value'=>CheckoutForm::ADDRESS_TYPE_EXISTING ]) ?> 
			<?= Yii::t('shop', 'I want to use an existing address') ?>
		</label>
	</div>
	<div id="address-exist">
		<?= Html::activeDropDownList($model, 'shippingAddressId', $addresses, 
		['class'=>'form-control', 'prompt'=>Yii::t('shop','-- Please select --')]) ?>
	</div>
	<div class="radio">
		<label>
			<?= Html::radio($cname, 
			$model->shippingAddressType==CheckoutForm::ADDRESS_TYPE_NEW, 
			['class'=>'address-type', 'value'=>CheckoutForm::ADDRESS_TYPE_NEW]) ?> 
			<?= Yii::t('shop', 'I want to use a new address') ?>
		</label>
	</div>
	<?php endif ?>
	<div id="address-new">
		<?= $this->render('addressForm', [
			'model'=>$model->shippingAddress,
			'form'=>$form,
		]) ?>
	</div>
<?php ActiveForm::end(); ?>
