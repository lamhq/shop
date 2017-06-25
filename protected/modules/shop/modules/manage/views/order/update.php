<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model shop\modules\manage\models\Product */

$this->title = Yii::t('shop', 'Edit Order #{0}', $model->id);
$this->params['breadcrumbs'][] = [
	'label' => Yii::t('shop', 'Orders'), 
	'url' => ['index']
];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
