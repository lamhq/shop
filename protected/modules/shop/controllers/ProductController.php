<?php

namespace shop\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use shop\models\Product;
use shop\models\AddToCartForm;

/**
 * @author Lam Huynh <lamhq.com>
 */
class ProductController extends Controller
{
	/**
	 * @param $slug
	 * @return string
	 * @throws NotFoundHttpException
	 */
	public function actionView($slug)
	{
		$c = Yii::$app->cart;
		$model = Product::find()
			->active()
			->instock()
			->visible()
			->bySlug($slug)
			->one();
		if (!$model) {
			throw new NotFoundHttpException;
		}

		$cart = new AddToCartForm([
			'productId' => $model->id,
			'qty' => 1
		]);
		return $this->render('view', [
			'model'=>$model,
			'cart'=>$cart
		]);
	}
}
