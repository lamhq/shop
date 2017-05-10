<?php
namespace shop\widgets;

use Yii;
use yii\base\Widget;
use shop\behaviors\CustomerCheckout;

class CartDropdown extends Widget {
	
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'checkout' => [
				'class' => CustomerCheckout::className(),
			],
		];
	}

	public function run() {
		$order = $this->getOrder();
		return $this->render('cartDropdown', [
			'order' => $order
		]);
	}	
}
