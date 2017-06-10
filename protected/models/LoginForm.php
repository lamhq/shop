<?php
namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
abstract class LoginForm extends Model
{
	public $username;
	public $password;
	public $rememberMe = true;

	protected $_user;


	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			// username and password are both required
			[['username', 'password'], 'required'],
			// rememberMe must be a boolean value
			['rememberMe', 'boolean'],
			// password is validated by validatePassword()
			['password', 'validatePassword'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'username' => Yii::t('app', 'Username'),
			'password' => Yii::t('app', 'Password'),
			'rememberMe' => Yii::t('app', 'Remember me'),
		];
	}

	/**
	 * Validates the password.
	 * This method serves as the inline validation for password.
	 *
	 * @param string $attribute the attribute currently being validated
	 * @param array $params the additional name-value pairs given in the rule
	 */
	public function validatePassword($attribute, $params)
	{
		if (!$this->hasErrors()) {
			$user = $this->getUser();
			if (!$user || !$user->validatePassword($this->password)) {
				$this->addError($attribute, Yii::t('app', 'Incorrect username or password.'));
			}
		}
	}

	/**
	 * Logs in a user using the provided username and password.
	 *
	 * @return bool whether the user is logged in successfully
	 */
	public function login()
	{
		if ($this->validate()) {
			return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
		} else {
			return false;
		}
	}

	/**
	 * Get user model
	 *
	 * @return yii\base\Model|null
	 */
	protected function getUser() {
		if ($this->_user === null) {
			$this->_user = $this->findUserByUsername($this->username);
		}

		return $this->_user;
	}

	/**
	 * Finds user by [[username]]
	 *
	 * @return yii\base\Model|null
	 */
	abstract protected function findUserByUsername($name);
}
