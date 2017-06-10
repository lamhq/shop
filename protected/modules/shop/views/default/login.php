<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\LoginForm */

$title = Yii::t('app', 'Login');
$this->title = Yii::$app->helper->getPageTitle($title);
$this->params['breadcrumbs'][] = $title;
?>
<div class="row">
	<div class="col-sm-4 col-sm-offset-4">
		<div class="well">
			<h2><?= $title ?></h2>
			<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
				<?php echo $form->field($model, 'username') ?>
				<?php echo $form->field($model, 'password')->passwordInput() ?>
				<?php echo $form->field($model, 'rememberMe')->checkbox(['class'=>'simple']) ?>
				<?php echo Html::submitButton(Yii::t('app', 'Login'), [
					'class' => 'btn btn-primary btn-flat btn-block',
					'name' => 'login-button'
				]) ?>
			<?php ActiveForm::end(); ?>
			<em><a href="<?= yii\helpers\Url::to(['/shop/default/request-password-reset']) ?>"><?= Yii::t('app', 'I forgot my password') ?></a></em>
		</div>
	</div>
</div>