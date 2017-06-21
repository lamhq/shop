<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model shop\modules\manage\models\Product */

$this->title = Yii::t('shop', 'Edit Order');
$this->params['breadcrumbs'][] = [
	'label' => Yii::t('shop', 'Orders'), 
	'url' => ['index']
];
$this->params['breadcrumbs'][] = Yii::t('shop', 'Edit Order');
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
