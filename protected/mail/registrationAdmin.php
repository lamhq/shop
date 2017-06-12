<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
<p><?= Yii::t('app', 'A new customer has signed up:') ?></p>

<p>
Web Site: <?= Yii::$app->params['siteName'] ?><br/>
<?= Yii::t('app', 'Name') ?>: <?= $customer->name ?><br/>
<?= Yii::t('app', 'E-Mail') ?>: <?= $customer->email ?><br/>
<?= Yii::t('app', 'Telephone') ?>: <?= $customer->telephone ?>
</p>