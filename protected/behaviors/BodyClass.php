<?php
namespace app\behaviors;

use Yii;
use yii\base\Behavior;

class BodyClass extends Behavior
{
	/**
	 * @return string
	 */
	public function getBodyClass() {
		$params = $this->owner->params;
		return isset($params['bodyClass']) ? $params['bodyClass'] : '';
	}

	/**
	 * @param string $s
	 */
	public function setBodyClass($s) {
		$this->owner->params['bodyClass'] = trim($s);
	}

	/**
	 * @param string $s
	 */
	public function addBodyClass($s) {
		$this->setBodyClass($this->getBodyClass().' '.$s);
	}
}