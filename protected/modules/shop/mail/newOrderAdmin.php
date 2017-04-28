<?php

/* @var $this yii\web\View */
/* @var $order shop\models\Order */
$f = Yii::$app->formatter;
?>
<p>You have received an order.</p>

<?= $this->render('_orderInfo', ['order'=>$order]) ?>
