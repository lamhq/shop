<?php
namespace shop\observers\price;

use Yii;
use yii\base\Object;

class SubTotal extends Object
{
	public function onCollectPrice($event) {
		$data = &$event->data;
		$subTotal = $event->sender->getSubTotal();
		$data['prices']['subTotal'] = [
			'code'	=> 'subTotal',
			'title'	=> Yii::t('shop', 'Sub-Total'),
			'value'	=> $subTotal,
		];
		$data['total'] += $subTotal;
	}

}