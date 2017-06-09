<?php

namespace shop\modules\customer\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use shop\models\AccountForm;

class AccountController extends Controller
{
	public function actionDashboard()
	{
		$account = Yii::$app->user->identity;
		$dataProvider = new ActiveDataProvider([
			'query' => $account->getOrders(),
			'pagination'=>['defaultPageSize'=>5],
			'sort' => ['defaultOrder'=>['created_at'=>SORT_DESC]],
		]);

		return $this->render('dashboard', [
			'account'=>$account,
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionEdit() {
		$model = AccountForm::findOne(Yii::$app->user->identity->id);
		if ( $model->load(Yii::$app->request->post()) 
			&& $model->save() ) {
			Yii::$app->helper->setSuccess(Yii::t('app', 'Data saved.'));
			return $this->refresh();
		}
		
		return $this->render('edit', [
			'model' => $model
		]);
	}
}