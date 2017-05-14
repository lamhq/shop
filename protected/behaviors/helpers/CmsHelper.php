<?php
namespace app\behaviors\helpers;

use Yii;
use yii\base\Behavior;
use app\models\Block;

/**
 * @author Lam Huynh <lamhq.com>
 */
class CmsHelper extends Behavior
{
	public function getPageTitle($text) {
		$t = array_filter([ $text, Yii::$app->params['siteName'] ]);
		return implode(' | ', $t);
	}

	public function getYesNoListData() {
		return [
			'1' => Yii::t('app', 'Yes'),
			'0' => Yii::t('app', 'No'),
		];
	}

	public function getLogoUrl() {
		return Yii::$app->helper->getStorageUrl('shop/logo.png');
	}
	
	public function block($identifier) {
		$model = Block::find()
			->andWhere(['identifier'=>$identifier])
			->one();
		return $model ? $model->content : '';
	}

}
