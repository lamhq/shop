<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $name;
$code = property_exists($exception, 'statusCode') ? $exception->statusCode : 500;
?>
<div class="error-page">
	<h2 class="headline text-yellow"> <?= $code ?></h2>

	<div class="error-content">
		<h3><i class="fa fa-warning text-yellow"></i> <?= Html::encode($message) ?></h3>

		<p>
			<?= Yii::t('backend', 'Click {0} to return.', Html::a(Yii::t('backend', 'here'), ['/backend'])) ?>
		</p>

	</div>
	<!-- /.error-content -->
</div>
