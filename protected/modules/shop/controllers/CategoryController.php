<?php

namespace shop\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use shop\models\Category;

class CategoryController extends Controller
{
	public function actionView($slug)
	{
        $model = Category::find()->active()->bySlug($slug)->one();
        if (!$model) {
            throw new NotFoundHttpException;
        }

		$query = $model->getProducts()
			->active()
			->instock()
			->visible();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination'=>['defaultPageSize'=>Yii::$app->params['defaultPageSize']]
		]);
		return $this->render('view', [
			'model'=>$model,
			'dataProvider'=>$dataProvider
		]);
	}

}
