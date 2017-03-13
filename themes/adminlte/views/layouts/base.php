<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\ArrayHelper;

\lamhq\yii2\asset\AdminLte::register($this);
$bodyClass = ArrayHelper::getValue($this->params, 'body-class').' skin-blue';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<?= $this->render('_head') ?>
</head>
<body class="<?= $bodyClass ?>">
	<?php $this->beginBody() ?>

	<?= $content ?>
	
	<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
