<?php
/* @var $this yii\web\View */
/* @var $model app\models\SettingForm */
/* @var $form yii\bootstrap\ActiveForm */
?>
<?= $form->field($model, 'mailProtocol')->dropdownList($model->getMailProtocolOptions()) ?>
<?= $form->field($model, 'mailSmtpHost')->textInput() ?>
<?= $form->field($model, 'mailSmtpUser')->textInput() ?>
<?= $form->field($model, 'mailSmtpPassword')->textInput() ?>
<?= $form->field($model, 'mailSmtpPort')->textInput() ?>
