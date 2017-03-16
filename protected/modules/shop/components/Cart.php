<?php
namespace shop\components;

use Yii;
use yii\base\Component;
use shop\models\CartItem;

class Cart  extends Component {

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

	/**
	 * customer id
	 * @var int
	 */
	protected $customer;

	/**
	 * session id
	 * @var string
	 */
	protected $session;

	public function init()
	{
		$this->cookieLifeTime = Yii::$app->params['cookieLifeTime'];
		$this->customer = (int)Yii::$app->user->id;
		$this->session = $this->getCartSessionId();
		$this->removeExpiredItems();
		$this->mergeCurrentCart();
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

	public function add($productId, $quantity) {
		$item = CartItem::find()
			->andWhere([
				'product_id'=>$productId,
				'customer_id'=>$this->customer,
				'session_id'=>$this->session,
			])->one();
		if (!$item) {
			$item = new CartItem([
				'product_id'=>$productId,
				'customer_id'=>$this->customer,
				'session_id'=>$this->session,
				'quantity'=>0,
			]);
		}
		$item->quantity += $quantity;
		return $item->save();
	}

	public function update($itemId, $quantity) {
		return CartItem::updateAll(['quantity'=>$quantity], [
			'id'=>$itemId, 
			'customer_id'=>$this->customer, 
			'session_id'=>$this->session,
		]);
	}

	public function remove($itemId) {
		return CartItem::deleteAll([
			'id'=>$itemId, 
			'customer_id'=>$this->customer, 
			'session_id'=>$this->session,
		]);
	}

	/**
	 * @return boolean
	 */
	public function hasItems() {
		return count($this->getItems());
	}

	public function getItems() {
		$result = [];
		$items = CartItem::find()
			->andWhere([
				'customer_id'=>$this->customer,
				'session_id'=>$this->session,
			])->all();
		foreach ($items as $item) {
			if ($item->getProduct() && $item->quantity>0) {
				$result[] = $item;
			} else {
				$item->delete();
			}
		}
		return $result;
	}

	/**
	 * remove all expired cart items of guest
	 * (customer=0 and time_add < now-cookieLifeTIme)
	 */
	public function removeExpiredItems() {
		CartItem::deleteAll('customer_id=0 AND added_at<NOW()-'.(int)$this->cookieLifeTime);
	}

	/**
	 * merge current cart with customer's cart items in the past
	 */
	public function mergeCurrentCart() {
		if ($this->customer>0) {
			// We want to change the session ID on all the old items in the customers cart
			CartItem::updateAll(['session_id'=>$this->session], ['customer_id'=>$this->customer]);

			// Once the customer is logged in we want to update the customers cart
			$items = CartItem::find()
				->andWhere([
					'customer_id'=>0,
					'session_id'=>$this->session
				])->all();
			foreach ($items as $item) {
				$item->delete();
				// The advantage of using $this->add is that it will check if the products already exist and increaser the quantity if necessary.
				$this->add($item->product_id, $item->quantity);
			}
		}
	}

	/**
	 * get list of applied prices for cart
	 * @return array
	 */
	public function getPrices() {
		$totals = [];
		$total = 0;
		$totalData = [
			'totals' => &$totals,
			'total'  => &$total
		];

		$this->applySubTotalPrice($totalData);
		$this->applyTotalPrice($totalData);

		return $totals;
	}

	/**
	 * @return float
	 */
	public function getSubTotal() {
		$total = 0;
		foreach ($this->getItems() as $item) {
			$total += $item->getTotal();
		}
		return $total;
	}

	/**
	 * apply sub total price to price list
	 * @param  array $total
	 */
	protected function applySubTotalPrice($totalData) {
		$sub_total = $this->getSubTotal();

		$totalData['totals'][] = [
			'title'      => Yii::t('shop', 'Sub-Total'),
			'value'      => $sub_total,
		];

		$totalData['total'] += $sub_total;
	}

	/**
	 * apply total price to price list
	 * @param  array $total
	 */
	protected function applyTotalPrice($totalData) {
		$totalData['totals'][] = [
			'title'      => Yii::t('shop', 'Total'),
			'value'      => max(0, $totalData['total']),
		];
	}

	public function hasStock() {
		return true;
	}
}