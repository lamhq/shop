<?php
namespace shop\models;

use Yii;
use app\models\LoginForm as BaseLogin;

/**
 * Login form
 */
class LoginForm extends BaseLogin
{
	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(), [
			'username' => Yii::t('app', 'Email or phone'),
		]);
	}

	/**
	 * Finds user by [[username]]
	 *
	 * @return yii\base\Model|null
	 */
	protected function findUserByUsername($name) {
		return Customer::findByUsername($name);
	}
}
