<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
/**
 * Default controller for the `backend` module
 */
class DefaultController extends Controller
{
	/**
	 * @inheritdoc
	 */
	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
		];
	}
}
