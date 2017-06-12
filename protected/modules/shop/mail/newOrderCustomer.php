<?php

/* @var $this yii\web\View */
/* @var $order shop\models\Order */
?>
<p><?= Yii::t('shop', 'Thank you for your interest in {0} products. Your order has been received and will be processed soon.', Yii::$app->params['siteName'] ) ?></p>

<?php if ($order->customer_id): ?>
<p><?= Yii::t('shop', 'To view your order click on the link below:') ?></p>
<p><a href="<?= $order->getCustomerViewLink(); ?>"><?= $order->getCustomerViewLink(); ?></a></p>
<?php endif ?>

<?= $this->render('_orderInfo', ['order'=>$order]) ?>

<p><?= Yii::t('shop', 'Please reply to this e-mail if you have any questions.') ?></p>
