<?php
namespace shop\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class AddToCartButton extends Widget {
	
	public $product;

	public function run() {
        $request = Yii::$app->getRequest();
		$csrfToken = Html::hiddenInput($request->csrfParam, $request->getCsrfToken());
		return $this->render('addToCartButton', [
			'product'=>$this->product,
			'csrfToken' => $csrfToken,
		]);
	}	
}
