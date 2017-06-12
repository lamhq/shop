<?php

/* @var $this yii\web\View */
/* @var $order shop\models\Order */
?>
<p><?= Yii::t('shop', 'You have received an order.') ?></p>

<?= $this->render('_orderInfo', ['order'=>$order]) ?>
