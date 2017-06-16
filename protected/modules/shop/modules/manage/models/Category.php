<?php
namespace shop\modules\manage\models;

use Yii;
use shop\models\Category as BaseCategory;

class Category extends BaseCategory
{
	public function getParentCategoryOptions() {
		return self::getCategoryOptions([$this->id]);
	}
}
