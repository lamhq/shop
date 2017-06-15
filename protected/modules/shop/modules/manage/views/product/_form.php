<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model shop\modules\manage\models\Product */
/* @var $form yii\bootstrap\ActiveForm */
hiqdev\yii2\assets\select2\Select2Asset::register($this);
$this->registerJs('app.setupProductForm();');
?>
<?php $this->beginBlock('buttons') ?>
	<button type="submit" form="productForm" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="<?= Yii::t('backend', 'Save') ?>"><i class="fa fa-save"></i></button>

	<a href="<?= Url::to(['index']) ?>" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="<?= Yii::t('backend', 'Cancel') ?>"><i class="fa fa-reply"></i></a>
<?php $this->endBlock() ?>

<?php $form = ActiveForm::begin([
	'id'=>'productForm',
	'layout'=>'horizontal',
	'fieldConfig' => [
		'horizontalCssClasses' => [
			'label' => 'col-sm-2',
			'wrapper' => 'col-sm-10',
		],
	],
]); ?>
	<?= $form->field($model, 'name')->textInput() ?>
	<?= $form->field($model, 'imageItems')->widget('app\widgets\AjaxUpload', [
		'uploadUrl' => Url::to(['/default/upload']),
		'multiple' => true,
		'extensions' => ['jpg', 'png', 'gif'],
		'maxSize' => 4000,
	]); ?>
	<?= $form->field($model, 'description')->widget(
		\yii\imperavi\Widget::className(),
		[
			'plugins' => ['fullscreen', 'fontcolor', 'video'],
			'options' => [
				'minHeight' => 400,
				'maxHeight' => 400,
				'buttonSource' => true,
				'convertDivs' => false,
				'removeEmptyTags' => false,
				'imageUpload' => Yii::$app->urlManager->createUrl(['/file-storage/upload-imperavi'])
			]
		]
	) ?>
	<?= $form->field($model, 'price')->textInput() ?>
	<?= $form->field($model, 'quantity')->textInput() ?>
	<?= $form->field($model, 'status')->dropdownList($model->getStatusOptions()) ?>
	<?= $form->field($model, 'available_time')->widget(
			'trntv\yii\datetime\DateTimeWidget',
			[ 'momentDatetimeFormat' => Yii::$app->helper->getDateFormat('datepicker') ]
		); 
	?>
	<?= $form->field($model, 'categoryIds')->dropdownList($model->getCategoryOptions(), [
		'multiple'=>'multiple',
		'class'=>'selectpicker',
		'style'=>'width:100%',
	]) ?>
	<?= $form->field($model, 'model')->textInput() ?>
	<?= $form->field($model, 'meta_title')->textInput() ?>
	<?= $form->field($model, 'meta_description')->textArea(['rows'=>5]) ?>
	<?= $form->field($model, 'meta_keyword')->textArea(['rows'=>5]) ?>
</div>

<?php ActiveForm::end(); ?>
