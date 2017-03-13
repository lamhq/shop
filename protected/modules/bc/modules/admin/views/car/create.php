<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model bc\models\Car */

$this->title = Yii::t('backend', 'Create {modelClass}', ['modelClass' => Yii::t('bc', 'Car')]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('bc', 'Car'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="car-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
