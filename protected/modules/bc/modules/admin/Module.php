<?php

namespace bc\modules\admin;
use Yii;
use yii\base\Controller;

/**
 * bc module definition class
 */
class Module extends \backend\Module
{
	/**
	 * @inheritdoc
	 */
	public $controllerNamespace = 'bc\modules\admin\controllers';

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		// custom initialization code goes here
		parent::init();

		// set theme adminlte for backend module
		Yii::$app->view->theme->pathMap['@bc/modules/admin/views'] = '@webroot/themes/adminlte/views';
	}
}
