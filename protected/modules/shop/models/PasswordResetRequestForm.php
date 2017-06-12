<?php
namespace shop\models;

use Yii;
use app\models\PasswordResetRequestForm as BaseForm;

class PasswordResetRequestForm extends BaseForm {

	public function findUserByEmail($email) {
		return Customer::findByEmail($email);
	}
}