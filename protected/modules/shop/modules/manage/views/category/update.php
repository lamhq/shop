<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model shop\models\Category */

$this->title = Yii::t('backend', 'Update {0}', Yii::t('shop', 'Category'));
$this->params['breadcrumbs'][] = [
	'label' => Yii::t('shop', 'Category'), 
	'url' => ['index']
];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="row">
	<div class="col-sm-4">
		<?= shop\modules\manage\widgets\CategoryNavigation::widget() ?>
	</div>
	<div class="col-sm-8">
		<?= $this->render('_form', [
		    'model' => $model,
		]) ?>
	</div>
</div>
