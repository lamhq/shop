<?php
/* @var $this \yii\web\View */
/* @var $model shop\models\Customer */

use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use shop\widgets\AccountNavigation;

$title = Yii::t('app', 'Edit Information');
$this->title = Yii::$app->helper->getPageTitle($title);
$this->params['breadcrumbs'][] = [
	'label' => Yii::t('app', 'My Dashboard'),
	'url' => ['account/dashboard'],
];
$this->params['breadcrumbs'][] = $title;
$this->registerJs('app.setupEditAccountPage();');
?>
<h1><?= $title ?></h1>

<?php $form = ActiveForm::begin([
	'layout' => 'horizontal',
]); ?>
<fieldset>
	<legend><?= Yii::t('app', 'Account Information') ?></legend>
		<?php echo $form->field($model, 'name') ?>
		<?php echo $form->field($model, 'telephone') ?>
		<?php echo $form->field($model, 'email') ?>
</fieldset>

<?php echo $form->field($model, 'changePassword')->checkbox() ?>

<fieldset class="cp-section">
	<legend><?= Yii::t('app', 'Change Password') ?></legend>
	<?php echo $form->field($model, 'password')->passwordInput() ?>
	<?php echo $form->field($model, 'password_repeat')->passwordInput() ?>
</fieldset>

<div class="form-group">
	<div class="col-sm-push-3 col-sm-9">
		<a href="<?= Url::to(['dashboard']) ?>" class="btn btn-default"><?= Yii::t('app', 'Back') ?></a>
		<button type="submit" class="btn btn-primary">&nbsp;&nbsp;<?= Yii::t('app', 'Update') ?>&nbsp;&nbsp;</button>
	</div>
</div>
<?php ActiveForm::end(); ?>

<?php $this->beginBlock('leftColumn') ?>
	<?= AccountNavigation::widget() ?>
<?php $this->endBlock() ?>
