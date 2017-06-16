<?php

namespace shop\modules\manage\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use shop\modules\manage\models\Category;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
{
	public $defaultAction = 'create';

	/**
	 * Creates a new Category model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Category();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->helper->setSuccess(Yii::t('backend', 'Data saved.'));
			return $this->redirect(['update', 'id'=>$model->id]);
		} else {
			return $this->render('create', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Updates an existing Category model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->helper->setSuccess(Yii::t('backend', 'Data saved.'));
			return $this->redirect(['update', 'id'=>$model->id]);
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Finds the Category model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Category the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Category::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
