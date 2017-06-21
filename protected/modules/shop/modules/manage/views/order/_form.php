<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
$this->registerJs('app.setupOrderForm();');
?>
<?php $this->beginBlock('buttons') ?>
	<button type="submit" form="orderForm" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="<?= Yii::t('backend', 'Save') ?>"><i class="fa fa-save"></i></button>

	<a href="<?= Url::to(['index']) ?>" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="<?= Yii::t('backend', 'Cancel') ?>"><i class="fa fa-reply"></i></a>
<?php $this->endBlock() ?>

<?php $form = ActiveForm::begin([
	'id'=>'orderForm',
]); ?>
<?= Html::activeHiddenInput($model, 'customer_id') ?>
<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab-customer" data-toggle="tab">Customer Details</a></li>
		<li><a href="#tab-product" data-toggle="tab">Products</a></li>
		<li><a href="#tab_3" data-toggle="tab">Shipping Details</a></li>
		<li><a href="#tab_4" data-toggle="tab">Payment Details</a></li>
		<li><a href="#tab_5" data-toggle="tab">Totals</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab-customer">
			<?= $this->render('form/customer', ['model'=>$model, 'form'=>$form]) ?>
		</div>
		<div class="tab-pane" id="tab-product">
			<?= $this->render('form/product', ['model'=>$model, 'form'=>$form]) ?>
		</div>
		<div class="tab-pane" id="tab_3">
		</div>
		<div class="tab-pane" id="tab_4">
		</div>
		<div class="tab-pane" id="tab_5">
			<?= $this->render('form/total', ['model'=>$model, 'form'=>$form]) ?>
		</div>
	</div>
</div>
<?php ActiveForm::end(); ?>
