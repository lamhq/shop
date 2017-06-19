<?php
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use app\widgets\DateTimeWidget;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
$this->registerJs('app.setupOrderFilterForm();');
?>

<div class="well">
<?php $form = ActiveForm::begin([
	'action' => ['index'],
	'method' => 'get',
]); ?>
	<div class="row">
		<div class="col-sm-4">
			<?php echo $form->field($model, 'id')->textInput() ?>
			<?php echo $form->field($model, 'name')->textInput() ?>
		</div>
		<div class="col-sm-4">
			<?php echo $form->field($model, 'status')->dropdownList($model->getStatusOptions(), ['prompt'=>'']) ?>
			<?php echo $form->field($model, 'total') ?>
		</div>
		<div class="col-sm-4">
			<?php echo $form->field($model, 'created_at')->widget(
				DateTimeWidget::className(),
				[ 'momentDatetimeFormat' => Yii::$app->helper->getDateFormat('datepicker2') ]
			) ?>
			<?php echo $form->field($model, 'updated_at')->widget(
				DateTimeWidget::className(),
				[ 'momentDatetimeFormat' => Yii::$app->helper->getDateFormat('datepicker2') ]
			) ?>
		</div>
	</div>

	<div class="">
		<button class="btn btn-primary" type="submit">
			<i class="fa fa-filter"></i> <?= Yii::t('backend', 'Filter') ?>
		</button>
	</div>

<?php ActiveForm::end(); ?>
</div>
