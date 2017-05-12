<?php
namespace app\widgets;

use Yii;
use yii\base\Widget;

class Slideshow extends Widget {
	
	public $slideshowId;

	public function run() {
		$model = \app\models\Slideshow::find()
			->andWhere(['id'=>$this->slideshowId])
			->active()
			->one();

		if (!$model || !$model->slideshowImages) return '';
		return $this->render('slideshow', [
			'model'=>$model
		]);
	}	
}
