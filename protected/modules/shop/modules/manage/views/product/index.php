<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('shop', 'Product');
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_search', ['model' => $model]); ?>

<?php $this->beginBlock('buttons') ?>
	<a href="<?= Url::to(['create']) ?>" class="btn btn-primary" data-toggle="tooltip" data-original-title="<?= Yii::t('backend', 'Add New') ?>"><i class="fa fa-plus"></i></a>
	<!--
	<button class="btn btn-default btn-multi-update" type="button">
		<i class="fa fa-pencil"></i>
	</button>
	-->
<?php $this->endBlock() ?>

<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'options' => [
		'class' => 'grid-view table-responsive'
	],
	'columns' => [
		['class' => 'yii\grid\CheckboxColumn'],
		[
			'attribute' => 'image',
			'format' => 'raw',
			'value' => function ($model) {
				return Html::img($model->getImageUrl(50,50));
			},
		],
		'name',
		'price:currency',
		'quantity',
		[
			'class' => 'app\components\EnumColumn',
			'attribute' => 'status',
			'enum' => $model->getStatusOptions(),
		],
		[
			'class' => 'yii\grid\ActionColumn',
			'buttonOptions' => ['class'=>'btn btn-primary'],
			'template' => '{update}',
		]
	]
]); ?>
