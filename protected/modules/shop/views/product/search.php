<?php
/* @var $this \yii\web\View */
/* @var $model \shop\models\search\Product */
use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

$title = Yii::t('shop', 'Search');
$this->title = Yii::$app->helper->getPageTitle($title);
$this->params['breadcrumbs'][] = Yii::t('shop', 'Search');
$this->registerJs('app.setupSearchPage();');
?>
<h1><?= $title ?> - <?= Html::encode($model->text) ?></h1>

<label class="control-label"><?= Yii::t('shop', 'Search Criteria') ?></label>

<?php $form = ActiveForm::begin([
	'method'=>'GET',
	'action'=>['/shop/product/search'],
]); ?>
	<div class="row">
		<div class="col-sm-4">
			<?= Html::activeTextInput($model, 'text', ['class'=>'form-control']) ?>
		</div>
		<div class="col-sm-3">
			<?= Html::activeDropDownList($model, 'categoryId', $model->getCategoryOptions(), ['class'=>'form-control', 'prompt'=>Yii::t('shop', 'All Categories'), 'encode'=>false ]) ?>
		</div>
		<div class="col-sm-3">
			<?= Html::activeCheckbox($model, 'inSubCategory', [
				'labelOptions'=>['class'=>'checkbox-inline'], 
				'uncheck'=>false,
			]) ?>
		</div>
	</div>

	<p>
		<?= Html::activeCheckbox($model, 'inDescription', [
			'labelOptions'=>['class'=>'checkbox-inline'], 
			'uncheck'=>false,
		]) ?>
	</p>

	<button type="submit" class="btn btn-primary"><?= Yii::t('shop', 'Search') ?></button>
<?php ActiveForm::end(); ?>

<h2><?= Yii::t('shop', 'Products meeting the search criteria') ?></h2>

<?= \shop\widgets\ProductList::widget([
	'dataProvider' => $dataProvider,
	'itemView' => '@shop/widgets/views/productThumb',
	'toolbarView' => '@shop/widgets/views/productListToolbar',
]); ?>