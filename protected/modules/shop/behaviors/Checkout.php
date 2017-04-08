<?php
namespace shop\behaviors;

use Yii;
use yii\base\Behavior;

class Checkout extends Behavior
{
	/**
	 * name of the cookie used to store session id
	 * @var string
	 */
	public $cookieName = 'csi';

	/**
	 * cookie life time in seconds
	 * @var string
	 */
	public $cookieLifeTime;

	public function getCheckout() {
		$model = new CheckoutForm();
		$model->setData($this->getCheckoutSessionData());
		return $model;
	}
	
	public function getCheckoutSessionData() {
		return Yii::$app->session->get('checkout');
	}

	public function setCheckoutSessionData($data) {
		Yii::$app->session->set('checkout', $data);
	}
	
	public function getCartSessionId() {
		$cookies = Yii::$app->request->cookies;
		$sid = $cookies->getValue($this->cookieName);
		if (!$sid) {
			$cookies = Yii::$app->response->cookies;
			$sid = Yii::$app->security->generateRandomString();
			$cookies->add(new \yii\web\Cookie([
				'name' => $this->cookieName,
				'value' => $sid,
				'expire' => time()+$this->cookieLifeTime,
			]));
		}
		return $sid;
	}

}