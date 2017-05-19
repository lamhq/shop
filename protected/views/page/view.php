<?php
/* @var $this yii\web\View */
/* @var $model app\models\Page */
$this->title = Yii::$app->helper->getPageTitle($model->title);
$this->params['breadcrumbs'][] = $model->title;
?>
<h1><?= $model->title ?></h1>

<?= $model->content ?>


