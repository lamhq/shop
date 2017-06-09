<?php
namespace shop\models;

use Yii;
use yii\base\Model;

class AccountForm extends Customer
{
	public $changePassword;
	public $password;
	public $password_repeat;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['name'], 'string', 'max' => 64],
			[['email'], 'string', 'max' => 96],
			[['telephone'], 'string', 'max' => 32],
			['changePassword', 'integer'],

			[['name','telephone'], 'required'],
			['email', 'trim'],
			['email', 'email'],
			['email', 'string', 'max' => 255],
			['email', 'unique', 'targetClass' => self::className(), 'message' => 'This email address has already been taken.'],
			['telephone', 'unique', 'targetClass' => self::className(), 'message' => 'This telephone number has already been taken.'],

			[['password','password_repeat'], 'required', 'when'=>function($model) {
					return (bool)$model->changePassword;
				}],
			['password', 'string', 'min' => 6],
			['password', 'compare', 'compareAttribute' => 'password_repeat', 'when'=>function($model) {
					return (bool)$model->changePassword;
				}],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(),  [
			'changePassword' => Yii::t('app', 'Change Password'),
			'password' => Yii::t('app', 'Password'),
			'password_repeat' => Yii::t('app', 'Password Repeat'),
		]);
	}

	public function afterValidate () {
		if ($this->changePassword) {
			$this->setPassword($this->password);
		}
	}
}
