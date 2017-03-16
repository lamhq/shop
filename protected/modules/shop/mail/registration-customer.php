<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
$loginUrl = Yii::$app->urlManager->createAbsoluteUrl(['/shop/default/login']);
?>
<p>Welcome and thank you for registering at <?= $storeName ?>!</p>

<p>Your account has now been created and you can log in by using your email address and password by visiting our website or at the following URL:</p>
<p><a href="<?= $loginUrl ?>"><?= $loginUrl ?></a></p>

<p>Upon logging in, you will be able to access other services including reviewing past orders, printing invoices and editing your account information.</p>

<p>Thanks,<br/>
<?= $storeName ?></p>