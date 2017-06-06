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
	const EVENT_AFTER_CHECKOUT = 'afterCheckout';

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					// 'place-order' => ['POST'],
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
		return $this->renderPartial('shippingGuest', [
			'model'=>$this->getOrder()
		]);
	}

	protected function handleLoggedShipping()
	{
		return $this->renderPartial('shipping', [
			'model'=>$this->getOrder()
		]);
	}

	/**
	 * @return string
	 * @throws NotFoundHttpException
	 */
	public function actionPayment()
	{
		return $this->renderPartial('payment', [
			'model'=>$this->getOrder()
		]);
	}

	/**
	 * @return string
	 * @throws NotFoundHttpException
	 */
	public function actionReview()
	{
		return $this->renderPartial('review', [
			'model'=>$this->getOrder()
		]);
	}

	/**
	 * @return array
	 * @throws NotFoundHttpException
	 */
	public function actionSaveData()
	{
		$model = $this->getOrder();
		$model->setData(Yii::$app->request->post());
		$this->saveOrderData();
		return Yii::$app->helper->jsonSuccess();
	}

	/**
	 * @return array
	 * @throws NotFoundHttpException
	 */
	public function actionPlaceOrder()
	{
		$model = $this->getOrder();
		if ( $model->placeOrder() ) {
			$event = Yii::$app->helper->createEvent([
				'sender' => $model,
			]);
			Yii::$app->trigger(self::EVENT_AFTER_CHECKOUT, $event);
			$data = $event->triggerData;
			return Yii::$app->helper->jsonSuccess('', $data);
		}

		return Yii::$app->helper->jsonError('', [
			'shipping' => $this->actionShipping(),
			'payment' => $this->actionPayment(),
			'review' => $this->actionReview(),
			'errors' => $model->getErrors(),
		]);
	}

	/**
	 * @return string
	 * @throws NotFoundHttpException
	 */
	public function actionSuccess()
	{
		$model = $this->getOrder();
		if (!$model->id)
			return $this->redirect(Url::home());
		$model->itemCollection->clear();
		$this->clearOrderSessionData();
		return $this->render('success', ['model'=>$model]);
	}

	/**
	 * @return string
	 * @throws NotFoundHttpException
	 */
	public function actionDropdown()
	{
		return \shop\widgets\CartDropdown::widget();
	}

}
