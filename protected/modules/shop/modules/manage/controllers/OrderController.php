<?php

namespace shop\modules\manage\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use shop\modules\manage\models\Order;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{
	/**
	 * Lists all Order models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$model = new Order(['scenario'=>'search']);
		$dataProvider = $model->search(Yii::$app->request->queryParams);
		$dataProvider->sort = [
			'defaultOrder'=>['updated_at'=>SORT_DESC]
		];
		return $this->render('index', [
			'model' => $model,
			'dataProvider' => $dataProvider
		]);
	}

	/**
	 * Creates a new Order model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Order(['scenario'=>'insert']);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->helper->setSuccess(Yii::t('backend', 'Data saved.'));
			return $this->redirect(['index']);
		} else {
			return $this->render('create', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Updates an existing Order model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->helper->setSuccess(Yii::t('backend', 'Data saved.'));
			return $this->redirect(['index']);
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Finds the Order model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Order the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Order::findOne($id)) !== null) {
			$model->scenario = 'update';
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
