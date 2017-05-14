<?php
namespace shop\widgets;

use Yii;
use yii\base\Widget;
use shop\models\Category;

class CategoryMenu extends Widget {
	
	public function run() {
		$categories = Category::find()
			->andWhere(['parent_id'=>null])
			->all();
		return $this->render('categoryMenu', [
			'categories' => $categories
		]);
	}	
}
