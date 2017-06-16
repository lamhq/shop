<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use shop\models\Category;
/* @var $this yii\web\View */
/* @var $model backend\models\search\ArticleSearch */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="well">
<?php $form = ActiveForm::begin([
	'action' => ['index'],
	'method' => 'get',
]); ?>
	<div class="row">
		<div class="col-sm-6">
			<?php echo $form->field($model, 'name') ?>
			<?php echo $form->field($model, 'price') ?>
		</div>
		<div class="col-sm-6">
			<?php echo $form->field($model, 'status')->dropdownList($model->getStatusOptions(), ['prompt'=>'']) ?>
			<?php echo $form->field($model, 'categoryId')->dropdownList(Category::getCategoryOptions(), ['prompt'=>'','encode'=>false]) ?>
		</div>
	</div>

	<div class="">
		<button class="btn btn-primary" type="submit">
			<i class="fa fa-filter"></i> <?= Yii::t('backend', 'Filter') ?>
		</button>
	</div>

<?php ActiveForm::end(); ?>
</div>
