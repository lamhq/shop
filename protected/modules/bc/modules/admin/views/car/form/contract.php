<div class="box box-info">
	<div class="box-header">
		<h3 class="box-title"><?= Yii::t('bc', 'Contract Info') ?></h3>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-6">
				<?= $form->field($model, 'HDTX_DateBegin')->widget(
					'app\widgets\DateTimeWidget', [
						'phpDatetimeFormat' => 'dd/MM/yyyy'
					]
				); ?>
			</div>
			<div class="col-md-6">
				<?= $form->field($model, 'HDTX_DateEnd')->widget(
					'app\widgets\DateTimeWidget', [
						'phpDatetimeFormat' => 'dd/MM/yyyy'
					]
				); ?>
			</div>
		</div>
	</div>
</div>
