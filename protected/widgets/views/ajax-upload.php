<?php
/* @var $this app\widgets\AjaxUpload */
/* @var $options array */
/* @var $attribute string */

use yii\helpers\Html;
\yii\jui\JuiAsset::register($this);
$this->registerJs(sprintf("app.setupAjaxUploadWidget(%s);", json_encode($options)));
?>
<div id="<?= $options['id'] ?>" class="ajax-upload">
	<?= Html::hiddenInput($options['name'], '', ['class'=>'placeholderInput']) ?>
	<?= Html::hiddenInput($csrfName, $csrfToken, ['class'=>'csrf', 'disabled'=>true]) ?>
	<div class="btn btn-default btn-file">
		<span class=""><?= Yii::t('app', 'Choose file') ?></span>
		<input type="file" class="ajax-file-input" />
	</div>

	<div class="loader fa fa-spinner fa-spin fa-fw hide"></div>
	
	<div class="upload-files">
	</div>
</div>