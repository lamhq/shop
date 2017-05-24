<?php
/* @var $this \yii\web\View */
/* @var $model \shop\models\search\ProductSearchForm */
use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::$app->helper->getPageTitle(Yii::t('shop', 'Search'));
$this->params['breadcrumbs'][] = Yii::t('shop', 'Search');
?>
<h1><?= Yii::t('shop', 'Search') ?> - <?= Html::encode($model->text) ?></h1>

<label class="control-label"><?= Yii::t('shop', 'Search Criteria') ?></label>

<?php $form = ActiveForm::begin([
]); ?>
	<div class="row">
		<div class="col-sm-4">
			<?= Html::activeTextInput($model, 'text', ['class'=>'form-control']) ?>
		</div>
		<div class="col-sm-3">
			<?= Html::activeDropDownList($model, 'categoryId', $model->getCategoryOptions(), ['class'=>'form-control', 'prompt'=>Yii::t('shop', 'All Categories'), 'encode'=>false ]) ?>
		</div>
		<div class="col-sm-3">
			<?= Html::activeCheckbox($model, 'inSubCategory', ['labelOptions'=>[
			'class'=>'checkbox-inline'] ]) ?>
		</div>
	</div>

	<p><?= Html::activeCheckbox($model, 'inDescription', ['labelOptions'=>[
			'class'=>'checkbox-inline'] ]) ?></p>

	<button type="submit" class="btn btn-primary"><?= Yii::t('shop', 'Search') ?></button>
<?php ActiveForm::end(); ?>

<?= \shop\widgets\ProductList::widget([
	'dataProvider' => $dataProvider,
	'itemView' => '@shop/widgets/views/productThumb',
	'toolbarView' => '@shop/widgets/views/productListToolbar',
]); ?>