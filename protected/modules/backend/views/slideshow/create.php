<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Slideshow */

$this->title = Yii::t('app', 'Create Slideshow');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Slideshows'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slideshow-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
