<?php
/* @var $model shop\models\AddToCartForm */
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
?>
<?php $form = ActiveForm::begin([
	'id' => 'addCartForm',
	'action' => ['/shop/cart/add'],
	'enableClientValidation' => true,
	'validateOnSubmit' => true,
	'options'=>['class'=>'add-cart-form'],
]); ?>
<?= \app\widgets\Alert::widget() ?>
<?= $form->field($model, 'qty') ?>
<?= $form->field($model, 'productId')->hiddenInput()->label(false) ?>
<br>
<button type="submit" data-loading-text="<?= Yii::t('app', 'Loading') ?>..." class="btn btn-primary btn-lg btn-block btn-cart">
	<?= Yii::t('shop', 'Add to Cart') ?>
</button>
<?php ActiveForm::end(); ?>
