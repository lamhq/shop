<?php
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
?>
<h2><?= Yii::t('shop', 'Write a review') ?></h2>

<?= \app\widgets\Alert::widget() ?>

<?php $form = ActiveForm::begin([
	'action' => ['/shop/review/form', 'productId'=>$model->product_id],
	'enableClientValidation' => true,
	'validateOnSubmit' => true,
]); ?>
	<?= $form->field($model, 'author') ?>
	
	<?= $form->field($model, 'text')->textArea(['rows'=>5]) ?>
	
	<?= $form->field($model, 'rating')->begin() ?>
		<?= Html::activeLabel($model, 'rating', ['class'=>'control-label']) ?>
		<div>
		<?= Yii::t('shop', 'Bad') ?>&nbsp;
		<?= Html::activeRadioList($model, 'rating', $model->getReviewRange(), [
			'tag'=>false,
			'item'=>function ($index, $label, $name, $checked, $value) {
				return Html::radio($name, $checked, ['value'=>$value]).'&nbsp;';
			}
		]) ?>
		<?= Yii::t('shop', 'Good') ?>
		</div>
		<?= Html::error($model, 'rating', ['class'=>'help-block help-block-error']) ?>
	<?= $form->field($model, 'rating')->end() ?>

	<?= $form->field($model, 'verificationCode')
		->widget(\yii\captcha\Captcha::classname(), [
			'captchaAction'=>['/default/captcha'],
			'template'=>'<div>{image} {input}</div>',
		])
		->label(Yii::t('shop', 'Please fill in verification code')); ?>

	<div class="text-right">
		<button type="submit" data-loading-text="<?= Yii::t('app', 'Loading...') ?>" 
		class="btn btn-primary"><?= Yii::t('shop', 'Submit review') ?></button>
	</div>
<?php ActiveForm::end(); ?>
