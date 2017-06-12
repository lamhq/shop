<?php
namespace shop\widgets;

use Yii;
use yii\base\Widget;

class AccountNavigation extends Widget {
	
	public function run() {
		return $this->render('accountNavigation');
	}	
}
