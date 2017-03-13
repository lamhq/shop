<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('backend', 'Reset password');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset-password">
    <p class="login-box-msg"><?= Html::encode($this->title) ?></p>
    
    <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
    <div class="body">
        <p><?= Yii::t('backend', 'Please choose your new password:') ?></p>
        <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>
        <?= $form->field($model, 'password_repeat')->passwordInput() ?>
    </div>
    <div class="footer">
        <?= Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
