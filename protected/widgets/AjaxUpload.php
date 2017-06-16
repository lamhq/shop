<?php
namespace app\widgets;

use Yii;
use yii\widgets\InputWidget;
use yii\helpers\Html;

/**
 * Description of AjaxUpload
 *
 * @author Lam Huynh
 */
class AjaxUpload extends InputWidget {
	
	/**
	 * @var string url to submit the file
	 */
	public $uploadUrl;
	
	/**
	 * @var boolean allow multiple file upload
	 */
	public $multiple = false;
	
	/**
	 * @var array allowed file extension
	 */
	public $extensions = array();
	
	/**
	 * @var float the maximum file size for upload in KB. 
	 * If set to 0, it means size allowed is unlimited. Defaults to 0.
	 */
	public $maxSize = 0;
	
	/**
	 * @var string current file link
	 */
	public $itemTemplate = '<div class="item">
		{removeButton}{img}{title}{input}
	</div>';

	/**
	 * Executes the widget.
	 * This method registers all needed client scripts and renders
	 * the widget
	 */
	public function run() {
		$this->prepareOptions();
		$this->id = $this->options['id'];
		return $this->render('ajax-upload', [
			'model'=>$this->model,
			'attribute'=>$this->attribute,
			'options'=>$this->options,
		]);
	}

	/**
	 * Registers the needed CSS and JavaScript.
	 */
	public function prepareOptions()
	{
		if ($this->hasModel()) {
			$model = $this->model;
			$attribute = $this->attribute;
			$this->name = Html::getInputName($this->model, $this->attribute);
			$this->value = $model->$attribute;
		}
		$this->options = array_merge([
			'uploadUrl' => $this->uploadUrl,
			'extensions' => $this->extensions,
			'maxSize' => $this->maxSize,
			'multiple' => $this->multiple,
			'itemTemplate' => $this->itemTemplate,
			'name' => $this->name,
			'value' => $this->value,
		], $this->options);
	}

}
