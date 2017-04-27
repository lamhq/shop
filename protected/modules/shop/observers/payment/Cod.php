<?php
namespace shop\observers\payment;

use Yii;
use yii\base\Object;

class Cod extends Object
{
	public function onOrderPlaced() {
		var_dump(1111);die;
	}

}