<?php
namespace shop\components;

use Yii;
use yii\base\InvalidConfigException;
use shop\models\CartItem;

class CustomerCartItemCollection extends CartItemCollection {

	/**
	 * @var string
	 */
	public $customerId;

	/**
	 * @var string
	 */
	public $collectionId;

	/**
	 * cookie life time in seconds
	 * @var string
	 */
	public $itemLifeTime;

	public function init() {
		parent::init();
		if ($this->customerId===null)
			throw new InvalidConfigException(get_class($this).' must define  "customerId" property.', 1);
		
		if ($this->collectionId===null)
			throw new InvalidConfigException(get_class($this).' must define  "collectionId" property.', 1);
		
		if (!$this->itemLifeTime)
			throw new InvalidConfigException(get_class($this).' must define  "itemLifeTime" property.', 1);

		$this->removeExpiredItems();
		$this->mergeCart();
	}

	public function add($productId, $quantity) {
		$item = CartItem::find()
			->andWhere([
				'product_id'=>$productId,
				'customer_id'=>$this->customerId,
				'session_id'=>$this->collectionId,
			])->one();
		if (!$item) {
			$item = new CartItem([
				'product_id'=>$productId,
				'customer_id'=>$this->customerId,
				'session_id'=>$this->collectionId,
				'quantity'=>0,
			]);
		}
		$item->quantity += $quantity;
		return $item->save();
	}

	public function update($itemId, $quantity) {
		return CartItem::updateAll(['quantity'=>$quantity], [
			'id'=>$itemId, 
			'customer_id'=>$this->customerId, 
			'session_id'=>$this->collectionId,
		]);
	}

	public function remove($itemId) {
		return CartItem::deleteAll([
			'id'=>$itemId, 
			'customer_id'=>$this->customerId, 
			'session_id'=>$this->collectionId,
		]);
	}

	public function getItems() {
		$result = [];
		$items = CartItem::find()
			->andWhere([
				'customer_id'=>$this->customerId,
				'session_id'=>$this->collectionId,
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

	public function hasStock() {
		return true;
	}

	/**
	 * remove all expired cart items of guest
	 * (customer=0 and time_add < now-cookieLifeTIme)
	 */
	protected function removeExpiredItems() {
		CartItem::deleteAll('customer_id=0 AND added_at<NOW()-'.(int)$this->itemLifeTime);
	}

	/**
	 * merge guest cart with customer's cart items in the past
	 */
	protected function mergeCart() {
		if ($this->customerId>0) {
			// We want to change the session ID on all the old items in the customers cart
			CartItem::updateAll(['session_id'=>$this->collectionId], ['customer_id'=>$this->customerId]);

			// Once the customer is logged in we want to update the customers cart
			$items = CartItem::find()
				->andWhere([
					'customer_id'=>0,
					'session_id'=>$this->collectionId
				])->all();
			foreach ($items as $item) {
				$item->delete();
				// The advantage of using $this->add is that it will check if the products already exist and increaser the quantity if necessary.
				$this->add($item->product_id, $item->quantity);
			}
		}
	}
}