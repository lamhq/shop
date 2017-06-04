<?php
/* @var $model shop\models\AddToCartForm */
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
?>
<?php $form = ActiveForm::begin([
	'action' => ['/shop/cart/add'],
	'enableClientValidation' => true,
	'validateOnSubmit' => true,
]); ?>
<?= \app\widgets\Alert::widget() ?>
<?= $form->field($model, 'qty') ?>

<div class="form-group">
	<?= Html::activeHiddenInput($model, 'productId') ?>
	<button type="submit" data-loading-text="<?= Yii::t('app', 'Loading...') ?>" class="btn btn-primary btn-lg btn-block btn-cart">
		<?= Yii::t('shop', 'Add to Cart') ?>
	</button>
</div>
<?php ActiveForm::end(); ?>
