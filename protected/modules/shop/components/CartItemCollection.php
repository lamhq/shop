<?php
namespace shop\components;

/**
 * @author Lam Huynh <hqlam.bt@gmail.com>
 */
abstract class CartItemCollection extends \yii\base\Object {

	/**
	 * @return boolean
	 */
	abstract public function add($productId, $quantity);

	/**
	 * @return boolean
	 */
	abstract public function update($itemId, $quantity);

	/**
	 * @return boolean
	 */
	abstract public function remove($itemId);

	/**
	 * @return shop\models\CartItem[]
	 */
	abstract public function getItems();

	/**
	 * @return shop\models\CartItem[]
	 */
	abstract public function hasStock();

	/**
	 * @return boolean
	 */
	public function hasItems() {
		return count($this->getItems());
	}
}