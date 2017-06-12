<?php
/* @var $this \yii\web\View */
/* @var $account shop\models\Customer */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use shop\widgets\AccountNavigation;

$title = Yii::t('app', 'My Dashboard');
$this->title = Yii::$app->helper->getPageTitle($title);
$this->params['breadcrumbs'][] = $title;
?>
<h1><?= $title ?></h1>

<fieldset>
	<legend><?= Yii::t('app', 'Account Information') ?></legend>
	<p><?= Yii::t('shop', 'Name') ?>: <?= $account->name ?></p>
	<p><?= Yii::t('shop', 'Telephone') ?>: <?= $account->telephone ?></p>
	<p><a href="<?= Url::to(['edit']) ?>"><?= Yii::t('app', 'Edit'); ?></a></p>
</fieldset>

<fieldset>
	<legend><?= Yii::t('shop', 'My Orders') ?></legend>
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
</fieldset>

<?php $this->beginBlock('leftColumn') ?>
	<?= AccountNavigation::widget() ?>
<?php $this->endBlock() ?>
