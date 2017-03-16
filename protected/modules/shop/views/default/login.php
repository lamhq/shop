<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\LoginForm */

$this->title = Yii::t('shop', 'Sign In');
?>
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="well">
			<h2><?= $this->title ?></h2>
			<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
				<?php echo $form->field($model, 'username') ?>
				<?php echo $form->field($model, 'password')->passwordInput() ?>
				<?php echo $form->field($model, 'rememberMe')->checkbox(['class'=>'simple']) ?>
				<?php echo Html::submitButton(Yii::t('backend', 'Sign In'), [
					'class' => 'btn btn-primary btn-flat btn-block',
					'name' => 'login-button'
				]) ?>
			<?php ActiveForm::end(); ?>
			<em><a href="<?= yii\helpers\Url::to(['/shop/default/request-password-reset']) ?>"><?= Yii::t('backend', 'I forgot my password') ?></a></em>
		</div>
	</div>
</div>