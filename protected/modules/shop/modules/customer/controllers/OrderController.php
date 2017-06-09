<?php

namespace shop\modules\customer\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;

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
		// $model = AccountForm::findOne(Yii::$app->user->identity->id);
		// if ( $model->load(Yii::$app->request->post()) 
		// 	&& $model->save() ) {
		// 	Yii::$app->helper->setSuccess(Yii::t('app', 'Data saved.'));
		// 	return $this->refresh();
		// }
		
		// return $this->render('edit', [
		// 	'model' => $model
		// ]);
	}
}