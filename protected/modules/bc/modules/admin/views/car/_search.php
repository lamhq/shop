<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model bc\models\search\Car */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="car-search">

	<?php $form = ActiveForm::begin([
		'action' => ['index'],
		'method' => 'get',
		'options' => [
			'data-pjax' => 1
		],
	]); ?>

	<div class="row">
		<div class="col-md-6">
			<?= $form->field($model, 'SoXe') ?>

			<?= $form->field($model, 'SoKhung') ?>
		</div>
		<div class="col-md-6">
			<?= $form->field($model, 'SoMay') ?>

			<?= $form->field($model, 'LoaiTaiSan')->dropDownList($model->getLoaiTaiSanOptions(), ['prompt'=>Yii::t('backend', '-- Please select --')]) ?>
		</div>
	</div>

	<?php // echo $form->field($model, 'TenXe') ?>

	<?php // echo $form->field($model, 'LoaiXe') ?>

	<?php // echo $form->field($model, 'NamSX') ?>

	<?php // echo $form->field($model, 'CSH') ?>

	<?php // echo $form->field($model, 'NganHangVay') ?>

	<?php // echo $form->field($model, 'HinhThucKD') ?>

	<?php // echo $form->field($model, 'NgayBanGiao') ?>

	<?php // echo $form->field($model, 'NgayThanhLy') ?>

	<?php // echo $form->field($model, 'HDTX_DateBegin') ?>

	<?php // echo $form->field($model, 'HDTX_DateEnd') ?>

	<?php // echo $form->field($model, 'GDKX_So') ?>

	<?php // echo $form->field($model, 'GDKX_NgayCap') ?>

	<?php // echo $form->field($model, 'GDKX_NgayHH') ?>

	<?php // echo $form->field($model, 'KDX_Ngay') ?>

	<?php // echo $form->field($model, 'NguyenGia') ?>

	<?php // echo $form->field($model, 'KhoaSoCua') ?>

	<?php // echo $form->field($model, 'GhiChu') ?>

	<?php // echo $form->field($model, 'PathImage') ?>

	<div class="form-group text-right">
		<button type="submit" class="btn btn-primary">
			<i class="fa fa-filter"></i>
			<?= Yii::t('backend', 'Filter') ?>
		</button>
	</div>

	<?php ActiveForm::end(); ?>

</div>
