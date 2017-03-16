<?php

namespace shop\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\bootstrap\ActiveForm;
use yii\filters\VerbFilter;
use shop\models\AddToCartForm;
use app\helpers\AppHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @author Lam Huynh <lamhq.com>
 */
class CartController extends Controller
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'add' => ['POST'],
				],
			],
		];
	}

	/**
	 * @return string
	 * @throws NotFoundHttpException
	 */
	public function actionAdd()
	{
		$result = ['success'=>0];		
		$model = new AddToCartForm();
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$product = $model->getProduct();
			$s = Yii::t('shop', 'Success: You have added {0} to your {1}!', [
				Html::a($product->name, $product->getUrl()), 
				Html::a('shopping cart', Url::to(['/shop/cart'])) 
			]);
			AppHelper::setSuccess($s);
			$model->qty = 1;
			$result['success'] = 1;
			$result['message'] = $s;
		}
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$result['cartForm'] = $this->renderPartial('_cartForm', [ 'model' => $model ]);
		$result['button'] = \shop\widgets\AddToCartButton::widget([ 'product' => $product ]);
		return $result;
	}

	/**
	 * @return string
	 * @throws NotFoundHttpException
	 */
	public function actionIndex()
	{
		$cart = Yii::$app->cart;
		return $this->render('index', ['cart'=>$cart]);
	}

	public function actionUpdate() {
		$cart = Yii::$app->cart;
		if ($data = Yii::$app->request->post('quantity')) {
			foreach ($data as $itemId => $quantity) {
				$cart->update($itemId, $quantity);
			}
		}
		return $this->redirect(['/shop/cart']);
	}

	public function actionRemove() {
		$result = ['success'=>0];		
		$cart = Yii::$app->cart;
		if ($item = Yii::$app->request->post('key')) {
			$result['success'] = $cart->remove($item);
		}
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return $result;
	}
}
