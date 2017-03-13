<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\widgets\Alert;

$this->params['body-class'] = 'login-page';
?>
<?php $this->beginContent('@webroot/themes/adminlte/views/layouts/base.php'); ?>
	<div class="login-box">
		<div class="login-logo">
			<?php echo Html::encode(Yii::$app->name) ?>
		</div>
		<div class="login-box-body">
	        <?= Alert::widget() ?>
			<?= $content ?>
		</div>
	</div>
<?php $this->endContent(); ?>
