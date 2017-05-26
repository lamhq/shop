<?php
namespace app\behaviors\helpers;

use Yii;
use yii\base\Behavior;
use yii\helpers\Url;
use app\models\Block;

/**
 * @author Lam Huynh <lamhq.com>
 */
class CmsHelper extends Behavior
{
	public function getPageTitle($text) {
		$t = array_filter([ $text, Yii::$app->params['siteTitle'] ]);
		return implode(' | ', $t);
	}

	public function getYesNoListData() {
		return [
			'1' => Yii::t('app', 'Yes'),
			'0' => Yii::t('app', 'No'),
		];
	}

	public function block($identifier) {
		$model = Block::find()
			->andWhere(['identifier'=>$identifier])
			->one();
		return $model ? $this->formatContent($model->content) : '';
	}

	public function replaceMarkups($text) {
		return preg_replace_callback('|{{(.*?)}}|', function($matches) {
			$result = '';
			$markups = preg_split("/\s+/", $matches[1]);
			$type = array_shift($markups);

			$params = [];
			foreach($markups as $m) {
				$kv = explode('=',$m);
				if (count($kv)!=2) continue;
				$params[$kv[0]] = $kv[1];
			}

			switch ($type) {
				case 'url':
					$result = Url::base();
					if (isset($params['page'])) {
						$result = Yii::$app->helper->getPageUrl($params['page']);
					}
					break;

				default:
					break;
			}
			return $result;
		}, $text);
	}

	public function formatContent($text) {
		return $this->replaceMarkups($text);
	}

}
