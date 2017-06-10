<?php
namespace backend\models;

use app\models\LoginForm as BaseLogin;

/**
 * Login form
 */
class LoginForm extends BaseLogin
{
	/**
	 * Finds user by [[username]]
	 *
	 * @return yii\base\Model|null
	 */
	protected function findUserByUsername($name) {
		return User::findByUsername($name);
	}
}
