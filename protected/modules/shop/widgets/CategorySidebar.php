<?php
namespace shop\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use shop\models\Category;

class CategorySidebar extends Widget
{
	private $_categories = null;

	public function run() {
		return $this->render('categorySidebar',[
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
            $category->path = $parent ? $parent->path.'/'.$category->slug 
            	: $category->slug;
            $result[] = [
            	'label'=>$label,
            	'url'=>$category->getUrl(),
            ];
        });
        return $result;
	}

}
