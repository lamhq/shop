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
		$model = $this->getOrder();
		$model->scenario = 'shippingGuest';
		if ( $model->setData(Yii::$app->request->post()) 
			&& $model->saveShippingGuest() ) {
			$this->saveOrderData($model);
			return Yii::$app->helper->jsonSuccess();
		}

		return $this->renderPartial('shippingGuest', ['model'=>$model]);
	}

	protected function handleLoggedShipping()
	{
		$model = $this->getOrder();
		$model->scenario = 'shipping';
		$model->setDefaultShippingAddress();
		if ( $model->setData(Yii::$app->request->post()) 
			&& $model->saveShipping() ) {
			$this->saveOrderData($model);
			return Yii::$app->helper->jsonSuccess();
		}

		return $this->renderPartial('shipping', [
			'model'=>$model,
		]);
	}

}
