<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model bc\models\Car */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $this->beginBlock('buttons') ?>
	<button type="submit" form="carForm" data-toggle="tooltip" title="<?= Yii::t('backend', 'Save') ?>" class="btn btn-primary">
		<i class="fa fa-save"></i>
	</button>

	<a href="<?= Url::to(['index']) ?>" data-toggle="tooltip" title="<?= Yii::t('backend', 'Cancel') ?>" class="btn btn-default">
		<i class="fa fa-reply"></i>
	</a>
<?php $this->endBlock() ?>

<div class="car-form">
	<?php $form = ActiveForm::begin([
		'id'=>'carForm',
	]); ?>

	<?= $this->render('form/main', ['model'=>$model, 'form'=>$form]) ?>
	<?= $this->render('form/owner', ['model'=>$model, 'form'=>$form]) ?>
	<?= $this->render('form/contract', ['model'=>$model, 'form'=>$form]) ?>

	<?php ActiveForm::end(); ?>
</div>
