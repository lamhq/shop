<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use app\models\SettingForm;

/**
 * Default controller for the `backend` module
 */
class SettingController extends Controller
{
	/**
	 * Renders the index view for the module
	 * @return string
	 */
	public function actionIndex() {
		$model = new SettingForm();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->helper->setSuccess(Yii::t('backend', 'Data saved.'));
			return $this->refresh();
		}

		return $this->render('index', [
			'model' => $model,
		]);
	}
}
