<?php
/* @var $this \yii\web\View */
/* @var $model shop\models\Customer */

use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

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
	<div class="col-sm-3 text-right">
		<a href="<?= Url::to(['dashboard']) ?>" class="btn btn-default"><?= Yii::t('app', 'Back') ?></a>
	</div>
	<div class="col-sm-9">
		<button type="submit" class="btn btn-primary"><?= Yii::t('app', 'Update') ?></button>
	</div>
</div>
<?php ActiveForm::end(); ?>
