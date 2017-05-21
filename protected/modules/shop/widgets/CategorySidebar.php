<?php
namespace shop\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use shop\models\Category;

class CategorySidebar extends Widget
{
	private $_categories = null;

	public function run() {
		return $this->render('categoryNav',[
			'items'=>$this->getCategoryMenuItems()
		]);
	}

	/*
	 * convert category models to array for use in Menu widget
	 */
	protected function getCategoryMenuItems() {
		return $this->categoriesToMenuItems(null);
	}

	protected function categoriesToMenuItems($category=null, $level=0) {
		$items = [];
		$categories = $this->findCategoriesByParent($category);
		foreach ($categories as $child) {
			if ($category) {
				$child->prependSlug($category->slug);
			}
			$item = [
				'label'=>str_repeat('&nbsp;', $level*5).sprintf('%s (%s)', $child->name, $child->productCount),
				'url'=> $child->getUrl(),
				'active' => $child->slug==\Yii::$app->request->getQueryParam('slug')
			];
			$items[] = $item;
			$items = array_merge($items, 
				$this->categoriesToMenuItems($child, $level+1));
		}
		return $items;
	}

	protected function findCategoriesByParent($category) {
		if ($this->_categories===null) {
			$this->_categories = Category::find()
			->active()
			->joinWith('categoryProducts')
			->select([
				'{{%shop_category}}.*', 
				'count({{%shop_category_product}}.product_id) as productCount'
			])
			->groupBy(['{{%shop_category}}.id'])
			->addOrderBy('sort_order ASC')
			->all();
		}

		$result = [];
		foreach ($this->_categories as $c) {
			if ( ($category && $c->parent_id==$category->id)
				|| (!$category && $c->parent_id==null) ) {
				$result[] = $c;
			}
		}
		return $result;
	}
}
