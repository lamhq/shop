<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model shop\modules\manage\models\Product */

$this->title = Yii::t('backend', 'Create {0}', Yii::t('shop', 'Product'));
$this->params['breadcrumbs'][] = [
	'label' => Yii::t('shop', 'Product'), 
	'url' => ['index']
];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Create');
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
