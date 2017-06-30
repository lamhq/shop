<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use app\models\Slideshow;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Slideshow');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginBlock('buttons') ?>
	<a href="<?= Url::to(['create']) ?>" class="btn btn-primary" data-toggle="tooltip" data-original-title="<?= Yii::t('backend', 'Add New') ?>"><i class="fa fa-plus"></i></a>
	<button class="btn btn-danger btn-delete" data-toggle="tooltip" data-original-title="<?= Yii::t('backend', 'Delete') ?>"><i class="fa fa-trash-o"></i></button>
<?php $this->endBlock() ?>

<?= GridView::widget([
	'id' => 'slideshowGrid',
	'dataProvider' => $dataProvider,
	'columns' => [
		['class' => 'yii\grid\CheckboxColumn'],
		'name',
		[
			'class' => 'app\components\EnumColumn',
			'attribute' => 'status',
			'enum' => Slideshow::getStatusOptions(),
		],
		[
			'class' => 'yii\grid\ActionColumn',
			'buttonOptions' => ['class'=>'btn btn-primary'],
			'template' => '{update}',
		]
	],
]); ?>
