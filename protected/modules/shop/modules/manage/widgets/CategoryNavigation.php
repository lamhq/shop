<?php
namespace shop\modules\manage\widgets;

use yii\base\Widget;
use yii\helpers\Url;
use shop\models\Category;

class CategoryNavigation extends Widget
{
	private $_categories = null;

	public function run() {
		return $this->render('categoryNavigation',[
			'items'=>$this->getCategoryMenuItems()
		]);
	}

	/*
	 * convert category models to array for use in Menu widget
	 */
	protected function getCategoryMenuItems() {
        $result = [];
        Category::travel(function ($category, $level, $parent) use (&$result) {
            $label = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level).($level>0 ? '- ' : '').$category->name;
            $result[] = [
            	'label' => $label,
            	'url' => Url::to(['category/update', 'id'=>$category->id]),
            ];
        });
        return $result;
	}

}
