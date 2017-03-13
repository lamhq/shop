<?php
use bc\models\CarBranch;
?>
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title"><?= Yii::t('bc', 'Main Info') ?></h3>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-6">
				<?= $form->field($model, 'SoXe')->textInput(['maxlength' => true]) ?>

				<?= $form->field($model, 'SoKhung')->textInput(['maxlength' => true]) ?>

				<?= $form->field($model, 'SoMay')->textInput(['maxlength' => true]) ?>

				<?= $form->field($model, 'LoaiTaiSan')->dropDownList($model->getLoaiTaiSanOptions(), ['prompt'=>Yii::t('backend', '-- Please select --')]) ?>

				<?= $form->field($model, 'TenXe')->textInput(['maxlength' => true]) ?>

				<?= $form->field($model, 'NamSX')->textInput() ?>
			</div>

			<div class="col-md-6">
				<?= $form->field($model, 'LoaiXe')->dropDownList(CarBranch::getOptions(), ['prompt'=>Yii::t('backend', '-- Please select --')]) ?>
				
				<?= $form->field($model, 'GDKX_So')->textInput(['maxlength' => true]) ?>

				<?= $form->field($model, 'GDKX_NgayCap')->widget(
					'app\widgets\DateTimeWidget', [
						'phpDatetimeFormat' => 'dd/MM/yyyy'
					]
				); ?>

				<?= $form->field($model, 'GDKX_NgayHH')->widget(
					'app\widgets\DateTimeWidget', [
						'phpDatetimeFormat' => 'dd/MM/yyyy'
					]
				); ?>

				<?= $form->field($model, 'NguyenGia')->textInput(['maxlength' => true]) ?>
			</div>
		</div>
	</div>
</div>
