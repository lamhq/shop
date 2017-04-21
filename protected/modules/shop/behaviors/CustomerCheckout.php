<?php
namespace shop\behaviors;

use Yii;
use yii\base\Behavior;
use shop\components\CustomerCartItemCollection;
use shop\models\CheckoutForm;

class CustomerCheckout extends Behavior
{
	/**
	 * name of the cookie used to store cart session id
	 * @var string
	 */
	public $cookieName = 'cart';

	/**
	 * cart item life time in seconds
	 * @var string
	 */
	public $cookieLifeTime = 3600*5;

	public function getOrder() {
		$userId = Yii::$app->user->id;
		$itemCollection = new CustomerCartItemCollection([
			'collectionId'=>$this->getCartSessionId(),
			'customerId'=>$userId,
			'itemLifeTime' => $this->cookieLifeTime,
		]);
		$model = new CheckoutForm([
			'itemCollection' => $itemCollection,
			'customer_id' => $userId,
		]);
		$model->setData($this->getOrderSessionData());
		return $model;
	}
	
	public function saveOrderData($order) {
		$this->setOrderSessionData($order->getData());
	}

	public function getOrderSessionData() {
		return Yii::$app->session->get('checkout');
	}

	public function setOrderSessionData($data) {
		Yii::$app->session->set('checkout', $data);
	}
	
	public function getCartSessionId() {
		$cookies = Yii::$app->request->cookies;
		$sid = $cookies->getValue($this->cookieName);
		if (!$sid) {
			$sid = Yii::$app->security->generateRandomString();
			$cookies = Yii::$app->response->cookies;
			$cookies->add(new \yii\web\Cookie([
				'name' => $this->cookieName,
				'value' => $sid,
				'expire' => time()+$this->cookieLifeTime,
			]));
		}
		return $sid;
	}

}