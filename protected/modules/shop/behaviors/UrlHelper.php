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
	public function getCategoryUrl($path) {
		$s = Url::to(['/shop/category/view', 'path'=>$path], true);
		// fix when adding parent category's slug to url
		$s = str_replace('%2F', '/', $s);
		return $s;
	}

	public function getProductUrl($path) {
		$s = Url::to(['/shop/product/view', 'path'=>$path], true);
		// fix when adding parent category's slug to url
		$s = str_replace('%2F', '/', $s);
		return $s;
	}

}
