<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model shop\modules\manage\models\Product */

$this->title = Yii::t('shop', 'Add Order');
$this->params['breadcrumbs'][] = [
	'label' => Yii::t('shop', 'Orders'), 
	'url' => ['index']
];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
