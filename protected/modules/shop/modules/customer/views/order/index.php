<?php
/* @var $this \yii\web\View */
/* @var $account shop\models\Customer */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$title = Yii::t('shop', 'Order History');
$this->title = Yii::$app->helper->getPageTitle($title);
$this->params['breadcrumbs'][] = [
	'label' => Yii::t('app', 'My Dashboard'),
	'url' => ['account/dashboard'],
];
$this->params['breadcrumbs'][] = $title;
?>
<h1><?= $title ?></h1>

<?php Pjax::begin(); ?>
<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'summary' => false,
	'options' => ['class'=>'grid-view table-responsive'],
	'columns' => [
		[
			'attribute' => 'id',
			'value' => function ($model, $key, $index, $column) {
				return '#'.$model->id;
			},
		],
		'name',
		'numberOfProducts',
		'displayStatus',
		[
			'attribute' => 'total',
			'format' => 'currency',
			'contentOptions' => ['class'=>'text-right'],
		],
		'created_at:date',
		[
			'value' => function ($model, $key, $index, $column) {
				return Html::a('<i class="fa fa-search"></i>', $model->getCustomerViewLink(), [
						'class'=>'btn btn-info',
						'data-toggle'=>"tooltip", 
						'title'=>Yii::t('app', "View"),
					]);
			},
			'format'=>'raw',
		],
	],
]) ?>
<?php Pjax::end(); ?>
