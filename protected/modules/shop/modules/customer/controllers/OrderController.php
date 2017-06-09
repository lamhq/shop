<?php

namespace shop\modules\customer\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use shop\models\Order;

class OrderController extends Controller
{
	public function actionIndex()
	{
		$account = Yii::$app->user->identity;
		$dataProvider = new ActiveDataProvider([
			'query' => $account->getOrders(),
			'pagination'=>['defaultPageSize'=>Yii::$app->params['defaultPageSize']],
			'sort' => ['defaultOrder'=>['created_at'=>SORT_DESC]],
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionView($id) {
		$model = Order::findOne($id);
		if (!$model || $model->customer_id!=Yii::$app->user->id) {
            throw new NotFoundHttpException;
		}

		return $this->render('view', [
			'model' => $model
		]);
	}
}