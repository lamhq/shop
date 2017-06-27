<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\SettingForm */
/* @var $form yii\bootstrap\ActiveForm */

$this->title = Yii::t('backend', 'Setting');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginBlock('buttons') ?>
	<button type="submit" form="settingForm" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="<?= Yii::t('backend', 'Save') ?>"><i class="fa fa-save"></i></button>

	<a href="<?= Url::to(['index']) ?>" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="<?= Yii::t('backend', 'Cancel') ?>"><i class="fa fa-reply"></i></a>
<?php $this->endBlock() ?>

<?php $form = ActiveForm::begin([
	'id'=>'settingForm',
]); ?>
<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
		<li><a href="#tab-mail" data-toggle="tab">Mail</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab-general">
			<?= $this->render('form/general', ['model'=>$model, 'form'=>$form]) ?>
		</div>
		<div class="tab-pane" id="tab-mail">
			<?= $this->render('form/mail', ['model'=>$model, 'form'=>$form]) ?>
		</div>
	</div>
</div>
<?php ActiveForm::end(); ?>
