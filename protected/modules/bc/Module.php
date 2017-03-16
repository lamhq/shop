<?php

namespace bc;
use Yii;
use yii\base\Controller;

/**
 * bc module definition class
 */
class Module extends \yii\base\Module
{
	/**
	 * @inheritdoc
	 */
	public $controllerNamespace = 'bc\controllers';

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		// custom initialization code goes here
		parent::init();
	}
}
