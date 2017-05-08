<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\modules\user\models\SignupForm */

$this->title = Yii::t('shop', 'Register Account');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="register-page">
	<h1><?php echo Html::encode($this->title) ?></h1>

	<?php $form = ActiveForm::begin([
		'id' => 'registerForm',
		'layout' => 'horizontal',
	]); ?>
		<fieldset>
			<legend><?= Yii::t('shop', 'Your Personal Details') ?></legend>
			<?php echo $form->field($model, 'name') ?>
			<?php echo $form->field($model, 'telephone') ?>
			<?php echo $form->field($model, 'email') ?>
		</fieldset>
		<fieldset>
			<legend><?= Yii::t('shop', 'Your Password') ?></legend>
			<?php echo $form->field($model, 'password')->passwordInput() ?>
			<?php echo $form->field($model, 'password_repeat')->passwordInput() ?>
		</fieldset>
		<fieldset>
			<legend><?= Yii::t('shop', 'Newsletter') ?></legend>
			<?php echo $form->field($model, 'newsletter')->inline()->radioList(Yii::$app->helper->getYesNoListData()) ?>
		</fieldset>
		<div class="form-group">
			<div class="col-sm-offset-3 col-sm-9">
				<button type="submit" class="btn btn-primary"><?= Yii::t('app', 'Submit') ?></button>
			</div>
		</div>
	<?php ActiveForm::end(); ?>
</div>
