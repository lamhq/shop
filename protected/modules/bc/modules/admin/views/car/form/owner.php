<?php
use kartik\select2\Select2;
?>
<div class="box box-success">
	<div class="box-header">
		<h3 class="box-title"><?= Yii::t('bc', 'Owner Info') ?></h3>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-6">
				<?= $form->field($model, 'CSH')->textInput(['maxlength' => true]) ?>

				<?= $form->field($model, 'NganHangVay')->widget(Select2::classname(), [
					'data' => $model->getNganHangOptions(),
					'options' => ['placeholder' => Yii::t('backend', '-- Please select --')],
					'theme'=>Select2::THEME_BOOTSTRAP,
					'pluginOptions' => [
						'allowClear' => true, 
						'tags' => true
					],
				]); ?>

				<?= $form->field($model, 'HinhThucKD')->textInput(['maxlength' => true]) ?>
	
				<?= $form->field($model, 'NgayBanGiao')->widget(
					'app\widgets\DateTimeWidget', [
						'phpDatetimeFormat' => 'dd/MM/yyyy'
					]
				); ?>

				<?= $form->field($model, 'NgayThanhLy')->widget(
					'app\widgets\DateTimeWidget', [
						'phpDatetimeFormat' => 'dd/MM/yyyy'
					]
				); ?>
			</div>
			<div class="col-md-6">
				<?= $form->field($model, 'KhoaSoCua')->textInput(['maxlength' => true]) ?>

				<?= $form->field($model, 'KDX_Ngay')->widget(
					'app\widgets\DateTimeWidget', [
						'phpDatetimeFormat' => 'dd/MM/yyyy'
					]
				); ?>

				<?= $form->field($model, 'GhiChu')->textInput(['maxlength' => true]) ?>
			</div>
		</div>
	</div>
</div>
