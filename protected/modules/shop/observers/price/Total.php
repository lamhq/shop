<?php
namespace shop\observers\price;

use Yii;
use yii\base\Object;

class Total extends Object
{
	public function onCollectPrice($event) {
		$data = &$event->data;
		$data['prices']['total'] = [
			'code'	=> 'total',
			'title'	=> Yii::t('shop', 'Total'),
			'value'	=> $data['total'],
		];
	}

}