<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use app\models\Page;

class PageController extends Controller {

	public function actionView($slug) {
		$model = Page::findBySlug($slug);
		if (!$model) {
			throw new \yii\web\NotFoundHttpException(Yii::t('app', 'The requested page does not exist'));
		}
		
		return $this->render('view', [
			'model' => $model
		]);
	}
}
