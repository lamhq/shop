<?php
/* @var $this app\widgets\AjaxUpload */
/* @var $options array */
/* @var $attribute string */

use yii\helpers\Html;
$this->registerJs(sprintf("app.setupAjaxUploadWidget(%s);", json_encode($options)));
?>
<div id="<?= $options['id'] ?>">
	<?= Html::hiddenInput($options['name'], '', ['class'=>'placeholderInput']) ?>
	<div class="btn btn-default btn-file">
		<span class="">Choose file</span>
		<input type="file" class="ajax-file-input" />
	</div>
	<div class="loader fa fa-spinner fa-spin fa-fw hide"></div>
	
	<div class="ajax-files row">
	</div>
</div>