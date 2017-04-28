<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
<p>A new customer has signed up:</p>

<p>
Web Site: <?= Yii::$app->name ?><br/>
Name: <?= $customer->name ?><br/>
E-Mail: <?= $customer->email ?><br/>
Telephone: <?= $customer->telephone ?>
</p>