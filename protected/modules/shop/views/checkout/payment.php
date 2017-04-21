<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use shop\models\CheckoutForm;

/* @var $this yii\web\View */
/* @var $model shop\models\CheckoutForm */
$cname = Html::getInputName($model, 'payment_code');
?>
<h3><?= Yii::t('shop', 'Payment Detail') ?></h3>

<p><?= Yii::t('shop', 'Please select the preferred payment method to use on this order.') ?></p>

<?php $form = ActiveForm::begin(['id' => 'paymentForm']); ?>
	<?php foreach ($model->getAvailablePaymentMethods() as $item): ?>
	<div class="radio">
		<label>
			<?= Html::radio($cname, $model->payment_code==$item['code'], 
				['value'=>$item['code']]) ?> <?= $item['title'] ?>
		</label>
	</div>
	<?php endforeach ?>

	<?php echo $form->field($model, 'comment')->textArea() ?>
<?php ActiveForm::end(); ?>