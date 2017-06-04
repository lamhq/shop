<?php
namespace shop\widgets;

use Yii;
use yii\base\Widget;
use shop\models\Review;

class Rating extends Widget {
	
	public $value;

	public function run() {
		$range = Review::getReviewRange();
		return $this->render('rating', [
			'min'=>$range[0],
			'max'=>$range[count($range)-1],
			'value'=>$this->value,
		]);
	}	
}
