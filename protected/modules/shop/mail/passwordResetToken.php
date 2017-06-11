<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user shop\models\Customer */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/shop/default/reset-password', 'token' => $user->password_reset_token]);

?>
<div class="password-reset">
	<p><?= Yii::t('app', 'A new password was requested for {0} customer account.', Yii::$app->params['siteName']) ?></p>

	<p><?= Yii::t('app', 'To reset your password click on the link below:') ?></p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
