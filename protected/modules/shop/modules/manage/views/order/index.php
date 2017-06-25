<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('shop', 'Order');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs('app.setupOrderGrid();');
?>
<?= $this->render('_search', ['model' => $model]); ?>

<?php $this->beginBlock('buttons') ?>
	<a href="<?= Url::to(['create']) ?>" class="btn btn-primary" data-toggle="tooltip" data-original-title="<?= Yii::t('backend', 'Add New') ?>"><i class="fa fa-plus"></i></a>
	<button class="btn btn-danger btn-delete" data-toggle="tooltip" data-original-title="<?= Yii::t('backend', 'Delete') ?>"><i class="fa fa-trash-o"></i></button>
<?php $this->endBlock() ?>

<?= GridView::widget([
	'id' => 'orderGrid',
	'dataProvider' => $dataProvider,
	'options' => [
		'class' => 'grid-view table-responsive'
	],
	'columns' => [
		['class' => 'yii\grid\CheckboxColumn'],
		'id',
		'name',
		[
			'class' => 'app\components\EnumColumn',
			'attribute' => 'status',
			'enum' => $model->getStatuses(),
		],
		[
			'attribute' => 'total',
			'format' => 'currency',
			'contentOptions' => ['class'=>'text-right'],
		],
		'created_at:date',
		'updated_at:date',
		[
			'class' => 'yii\grid\ActionColumn',
			'buttonOptions' => ['class'=>'btn btn-primary'],
			'template' => '{view} {update}',
		]
	]
]); ?>
