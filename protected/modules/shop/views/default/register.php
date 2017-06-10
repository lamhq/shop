<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\modules\user\models\SignupForm */

$title = Yii::t('app', 'Register Account');
$this->title = Yii::$app->helper->getPageTitle($title);
$this->params['breadcrumbs'][] = $title;
?>
<div class="register-page">
	<h1><?= $title ?></h1>

	<?php $form = ActiveForm::begin([
		'id' => 'registerForm',
		'layout' => 'horizontal',
	]); ?>
		<fieldset>
			<legend><?= Yii::t('app', 'Your Personal Details') ?></legend>
			<?php echo $form->field($model, 'name') ?>
			<?php echo $form->field($model, 'telephone') ?>
			<?php echo $form->field($model, 'email') ?>
		</fieldset>
		<fieldset>
			<legend><?= Yii::t('app', 'Your Password') ?></legend>
			<?php echo $form->field($model, 'password')->passwordInput() ?>
			<?php echo $form->field($model, 'password_repeat')->passwordInput() ?>
		</fieldset>
		<div class="form-group">
			<div class="col-sm-offset-3 col-sm-9">
				<button type="submit" class="btn btn-primary"><?= Yii::t('app', 'Register') ?></button>
			</div>
		</div>
	<?php ActiveForm::end(); ?>
</div>
