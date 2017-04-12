<?php
namespace shop\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use shop\models\Category;

class CategoryNavigation extends Widget
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
		$categories = $this->findCategoriesByParentId(null);
        return $this->categoriesToMenuItems($categories);
    }

    protected function categoriesToMenuItems($categories, $level=0) {
        $items = [];
        foreach ($categories as $c) {
            $item = [
	            'label'=>str_repeat('&nbsp;', $level*5).sprintf('%s (%s)', $c->name, $c->productCount),
	            'url'=> $c->getUrl(),
	            'active' => $c->slug==\Yii::$app->request->getQueryParam('slug')
	        ];
            $items[] = $item;
            $items = array_merge($items, 
            	$this->categoriesToMenuItems($this->findCategoriesByParentId($c->id), $level+1));
        }
        return $items;
    }

    protected function findCategoriesByParentId($parentId) {
    	if ($this->_categories===null) {
    		$this->_categories = Category::find()
            ->active()
            ->addOrderBy('sort_order ASC')
            ->joinWith('categoryProducts', true)
            ->select([
            	'{{%shop_category}}.*', 
            	'count({{%shop_category_product}}.product_id) as productCount'
            ])
            ->groupBy(['{{%shop_category}}.id'])
            ->all();
    	}

    	$result = [];
    	foreach ($this->_categories as $c) {
    		if ($c->parent_id==$parentId)
    			$result[] = $c;
    	}
    	return $result;
    }
}
