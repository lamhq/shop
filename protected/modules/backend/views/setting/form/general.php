<?php
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\SettingForm */
/* @var $form yii\bootstrap\ActiveForm */
?>
<?= $form->field($model, 'siteName')->textInput() ?>
<?= $form->field($model, 'adminEmail')->textInput() ?>
<?= $form->field($model, 'telephone')->textInput() ?>

<?= $form->field($model, 'uploadLogo')->widget('app\widgets\AjaxUpload', [
	'uploadUrl' => Url::to(['/default/upload']),
	'multiple' => false,
	'extensions' => ['jpg', 'png', 'gif'],
	'maxSize' => 4000,
])->hint(Yii::t('app','Logo displayed in top of website.')); ?>

<?= $form->field($model, 'uploadIcon')->widget('app\widgets\AjaxUpload', [
	'uploadUrl' => Url::to(['/default/upload']),
	'multiple' => false,
	'extensions' => ['ico', 'jpg', 'png', 'gif'],
	'maxSize' => 4000,
])->hint(Yii::t('app','Icon displayed in browser\'s window.')); ?>

<?= $form->field($model, 'metaTitle')->textInput()
	->hint(Yii::t('app','Title displayed in browser.')) ?>
<?= $form->field($model, 'metaDescription')->textInput()
	->hint(Yii::t('app','Use for SEO.')) ?>
<?= $form->field($model, 'metaKeyword')->textInput()
	->hint(Yii::t('app','Use for SEO.')) ?>