<?php

namespace shop\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\bootstrap\ActiveForm;
use yii\filters\VerbFilter;
use app\helpers\AppHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use shop\models\CheckoutForm;

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
					'add' => ['POST'],
				],
			],
		];
	}

	/**
	 * @return string
	 * @throws NotFoundHttpException
	 */
	public function actionIndex()
	{
		return $this->render('index');
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
		$model = new CheckoutForm();
		$model->setData($this->getCheckoutSessionData());
		$model->scenario = 'shipping-guest';
		if ($model->setData(Yii::$app->request->post()) && $model->saveShippingGuest()) {
			$this->setCheckoutSessionData($model->getData());
			return AppHelper::jsonSuccess();
		}

		return $this->renderPartial('shipping-guest', ['model'=>$model]);
	}

	protected function handleLoggedShipping()
	{
		$model = new CheckoutForm();
		$model->setData($this->getCheckoutSessionData());
		$model->scenario = 'shipping';
		$model->customer = Yii::$app->user->identity;
		if ($model->customer->getAddressOptions()) {
			$model->shippingAddressType = CheckoutForm::ADDRESS_EXISTING;
			$model->shippingAddressId = $model->customer->address_id;
		} else {
			$model->shippingAddressType = CheckoutForm::ADDRESS_NEW;
		}
		
		if ($model->setData(Yii::$app->request->post()) && $model->saveShipping()) {
			$this->setCheckoutSessionData($model->getData());
			return AppHelper::jsonSuccess();
		}

		return $this->renderPartial('shipping', [
			'model'=>$model,
		]);
	}

	public function getCheckoutSessionData() {
		return Yii::$app->session->get('checkout');
	}

	public function setCheckoutSessionData($data) {
		Yii::$app->session->set('checkout', $data);
	}

}
