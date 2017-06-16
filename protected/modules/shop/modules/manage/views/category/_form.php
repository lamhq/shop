<?php

use yii\helpers\Url; 
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */ 
/* @var $model shop\models\Category */ 
/* @var $form yii\widgets\ActiveForm */ 
?> 
<?php $this->beginBlock('buttons') ?>
	<button type="submit" form="categoryForm" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="<?= Yii::t('backend', 'Save') ?>"><i class="fa fa-save"></i></button>

	<a href="<?= Url::to(['create']) ?>" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="<?= Yii::t('backend', 'Add new') ?>"><i class="fa fa-plus"></i></a>
<?php $this->endBlock() ?>

<?php $form = ActiveForm::begin([
	'id'=>'categoryForm',
	// 'layout'=>'horizontal',
]); ?> 
 
	<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'uploadImage')->widget('app\widgets\AjaxUpload', [
		'uploadUrl' => Url::to(['/default/upload']),
		'multiple' => false,
		'extensions' => ['jpg', 'png', 'gif'],
		'maxSize' => 4000,
	]); ?>

	<?= $form->field($model, 'status')->dropdownList($model->getStatusOptions()) ?>

	<?= $form->field($model, 'sort_order')->textInput() ?>

	<?= $form->field($model, 'parent_id')->dropdownList($model->getParentCategoryOptions(),
	['prompt'=>Yii::t('shop', ''), 'encode'=>false, 'style'=>'font-family: monospace;' ]) ?>

	<?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'meta_keyword')->textInput(['maxlength' => true]) ?>
 
<?php ActiveForm::end(); ?> 