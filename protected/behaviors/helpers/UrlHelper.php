<?php
namespace app\behaviors\helpers;

use Yii;
use yii\base\Behavior;
use yii\helpers\Url;

/**
 * @author Lam Huynh <lamhq.com>
 */
class UrlHelper extends Behavior
{
	public function getLogoUrl() {
		return Yii::$app->helper->getStorageUrl('shop/logo.png');
	}

	public function getPageUrl($slug) {
		return Url::to(['/page/view', 'slug'=>$slug], true);
	}
	
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

	public function normalizeSlug($slug) {
		$parts = array_filter(explode('/', $slug));
		return array_pop($parts);
	}
}
