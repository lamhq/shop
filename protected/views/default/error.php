<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\helpers\Url;

$title = Yii::t('app', 'Error');
$this->params['breadcrumbs'][] = $title;
$this->title = Yii::$app->helper->getPageTitle($title);
?>
<div class="site-error">

    <h1><?= Yii::t('app', 'Something went wrong!') ?></h1>

    <p><?= $message ?></p>

    <p>
        <a href="<?= Url::home() ?>" class="btn btn-primary"><?= Yii::t('app', 'Continue') ?></a>
    </p>

</div>
