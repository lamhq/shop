<?php
namespace shop\models;

use Yii;

/**
 * Login form
 */
class LoginForm extends \backend\models\LoginForm
{
	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'username' => Yii::t('backend', 'Email or phone'),
			'password' => Yii::t('backend', 'Password'),
			'rememberMe' => Yii::t('backend', 'Remember me'),
		];
	}

	/**
	 * Finds user by [[username]]
	 *
	 * @return User|null
	 */
	protected function getUser()
	{
		if ($this->_user === null) {
			$this->_user = Customer::findByUsername($this->username);
		}

		return $this->_user;
	}
}
