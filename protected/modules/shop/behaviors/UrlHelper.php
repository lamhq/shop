<?php
namespace shop\behaviors;

use Yii;
use app\behaviors\helpers\UrlHelper as BaseUrlHelper;
use yii\helpers\Url;

/**
 * @author Lam Huynh <lamhq.com>
 */
class UrlHelper extends BaseUrlHelper
{
	public function getCategoryUrl($slug) {
		$s = Url::to(['/shop/category/view', 'slug'=>$slug], true);
		// fix when adding parent category's slug to url
		$s = str_replace('%2F', '/', $s);
		return $s;
	}

	public function getProductUrl($slug) {
		$s = Url::to(['/shop/product/view', 'slug'=>$slug], true);
		// fix when adding parent category's slug to url
		$s = str_replace('%2F', '/', $s);
		return $s;
	}

}
