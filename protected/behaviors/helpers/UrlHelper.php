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
		return Yii::$app->helper->getStorageUrl(Yii::$app->params['logo']);
	}

	public function getFaviconUrl() {
		return Yii::$app->helper->getStorageUrl(Yii::$app->params['favicon']);
	}

	public function getPageUrl($slug) {
		return Url::to(['/frontend/page/view', 'slug'=>$slug], true);
	}
	
	public function normalizeSlug($slug) {
		$parts = array_filter(explode('/', $slug));
		return array_pop($parts);
	}
}
