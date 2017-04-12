<?php

namespace shop\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Url;
use shop\models\AddToCartForm;
use shop\behaviors\CustomerCheckout;

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
			'checkout' => [
				'class' => CustomerCheckout::className(),
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
		$itemCollection = $this->getOrder()->itemCollection;
		if ( $model->load(Yii::$app->request->post()) 
			&& $model->validate() 
			&& $itemCollection->add($model->productId, $model->qty) ) {
			$model->resetFormData();

			// prepare success message
			$product = $model->getProduct();
			$s = Yii::t('shop', 'Success: You have added {0} to your {1}!', [
				Html::a($product->name, $product->getUrl()), 
				Html::a('shopping cart', Url::to(['/shop/cart'])) 
			]);
			$result['message'] = $s;
			$result['success'] = 1;
			Yii::$app->helper->setSuccess($s);
		}

		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
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
		return $this->render('index', [
			'model'=>$this->getOrder()
		]);
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
