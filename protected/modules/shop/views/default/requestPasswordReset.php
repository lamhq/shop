<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$title = Yii::t('app', 'Forgotten Password');
$this->title = Yii::$app->helper->getPageTitle($title);
$this->params['breadcrumbs'][] = $title;
?>
<h1><?= Yii::t('app', 'Forgot Your Password?') ?></h1>

<p><?= Yii::t('app', 'Enter the e-mail address associated with your account. Click submit to have a password reset link e-mailed to you.') ?></p>
	
<?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
	<?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
	<div class="form-group">
		<a href="<?= Url::home() ?>" class="btn btn-default"><?= Yii::t('app', 'Back') ?></a>
		<button type="submit" class="btn btn-primary"><?= Yii::t('app', 'Continue') ?></button>
	</div>
<?php ActiveForm::end(); ?>
