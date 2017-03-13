<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('backend', 'Request password reset');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-request-password-reset">
	<p class="login-box-msg"><?= Html::encode($this->title) ?></p>
	
	<?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
	<div class="body">
		<p><?= Yii::t('backend', 'Please fill out your email. A link to reset password will be sent there.') ?></p>
		<?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
	</div>
	<div class="footer">
		<?= Html::submitButton(Yii::t('backend', 'Get my password'), ['class' => 'btn btn-primary']) ?>
		<a href="<?= Url::to('/backend/default/login') ?>" class="btn btn-default"><?= Yii::t('backend', 'Back') ?></a>
	</div>
	<?php ActiveForm::end(); ?>
</div>
