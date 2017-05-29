<?php

/* @var $this yii\web\View */
/* @var $order shop\models\Order */
$f = Yii::$app->formatter;
?>
<p>Thank you for your interest in <?= Yii::$app->params['siteName'] ?> products. Your order has been received and will be processed once payment has been confirmed.</p>

<?php if ($order->customer_id): ?>
<p>To view your order click on the link below:</p>
<p><a href="<?= $order->getCustomerViewLink(); ?>"><?= $order->getCustomerViewLink(); ?></a></p>
<?php endif ?>

<?= $this->render('_orderInfo', ['order'=>$order]) ?>

<p>Please reply to this e-mail if you have any questions.</p>
