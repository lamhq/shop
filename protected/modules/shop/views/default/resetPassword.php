<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model shop\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$title = Yii::t('app', 'Reset your password');
$this->title = Yii::$app->helper->getPageTitle($title);
$this->params['breadcrumbs'][] = $title;
?>
<h1><?= $title ?></h1>

<p><?= Yii::t('app', 'Enter the new password you wish to use.') ?></p>
    
<?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
    <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'password_repeat')->passwordInput() ?>
    <div class="form-group">
        <a href="<?= Url::home() ?>" class="btn btn-default"><?= Yii::t('app', 'Back') ?></a>
        <button type="submit" class="btn btn-primary"><?= Yii::t('app', 'Continue') ?></button>
    </div>
<?php ActiveForm::end(); ?>
