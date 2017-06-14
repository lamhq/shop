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
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
			],
		];
	}

	/**
	 * Renders the index view for the module
	 * @return string
	 */
	public function actionIndex() {
		return 'welcome to yii2 core project';
	}

}