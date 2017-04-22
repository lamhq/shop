<?php

namespace shop\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\bootstrap\ActiveForm;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Url;
use shop\behaviors\CustomerCheckout;

/**
 * @author Lam Huynh <lamhq.com>
 */
class CheckoutController extends Controller
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
					'place-order' => ['POST'],
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
	public function actionShipping()
	{
		return Yii::$app->user->isGuest ? 
			$this->handleGuestShipping() :
			$this->handleLoggedShipping();
	}

	protected function handleGuestShipping()
	{
		$model = $this->getOrder();
		return $this->renderPartial('shippingGuest', ['model'=>$model]);
	}

	protected function handleLoggedShipping()
	{
		$model = $this->getOrder();
		$model->setDefaultShippingAddress();
		return $this->renderPartial('shipping', [
			'model'=>$model,
		]);
	}

	/**
	 * @return string
	 * @throws NotFoundHttpException
	 */
	public function actionPayment()
	{
		$model = $this->getOrder();
		return $this->renderPartial('payment', [
			'model'=>$model,
		]);
	}

	/**
	 * @return string
	 * @throws NotFoundHttpException
	 */
	public function actionReview()
	{
		$model = $this->getOrder();
		return $this->renderPartial('review', [
			'model'=>$model,
		]);
	}

	/**
	 * @return string
	 * @throws NotFoundHttpException
	 */
	public function actionSaveData()
	{
		$model = $this->getOrder();
		$data = Yii::$app->request->post();
		
		// reset payment method when changing shipping address
		if ( isset($data['Address']) ) {
			if ( !isset($data['CheckoutForm']) )
				$data['CheckoutForm'] = [];
			$data['CheckoutForm']['payment_code'] = null;
		}

		$model->setData($data);
		$this->saveOrderData($model);
		return Yii::$app->helper->jsonSuccess();
	}

	/**
	 * @return string
	 * @throws NotFoundHttpException
	 */
	public function actionPlaceOrder()
	{
		$model = $this->getOrder();
		if ( $model->placeOrder() ) {
			return Yii::$app->helper->jsonSuccess();
		}
		return Yii::$app->helper->jsonError('', [
			'shipping' => $this->actionShipping(),
			'payment' => $this->actionPayment(),
			'review' => $this->actionReview(),
		]);
	}
}
