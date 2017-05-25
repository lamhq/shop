<?php
namespace shop\widgets;

use Yii;
use yii\base\Widget;

class SearchForm extends Widget {
	
	public function run() {
		return $this->render('searchForm', [
			'text' => Yii::$app->request->get('text')
		]);
	}	
}
