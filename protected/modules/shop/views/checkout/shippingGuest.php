<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
$signup = $model->signupForm;
$shipping = $model->shippingAddress;
?>
<h3><?= Yii::t('shop', 'Shipping Detail') ?></h3>

<?php $form = ActiveForm::begin(['id' => 'shippingForm']); ?>
<div class="row">
	<div class="col-sm-12 col-md-6">
		<fieldset>
			<?php echo $form->field($model, 'name') ?>
			<?php echo $form->field($model, 'telephone') ?>
			<?php echo $form->field($model, 'email') ?>
			<?php echo $form->field($model, 'register')->checkbox() ?>
		</fieldset>
		<fieldset class="registration-section">
			<?php echo $form->field($signup, 'password')->passwordInput() ?>
			<?php echo $form->field($signup, 'password_repeat')->passwordInput() ?>
		</fieldset>
	</div>
	<div class="col-sm-12 col-md-6">
		<?= $this->render('addressForm', [
			'model'=>$model->shippingAddress,
			'form'=>$form,
		]) ?>
	</div>
</div>
<?php ActiveForm::end(); ?>
