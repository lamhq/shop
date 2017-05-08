<?php
namespace shop\models;

use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
	public $name;
	public $email;
	public $telephone;
	public $password;
	public $password_repeat;
	public $newsletter;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
            ['newsletter', 'integer'],
			['email', 'trim'],
			['telephone', 'required'],
			['email', 'email'],
			['email', 'string', 'max' => 255],
			['email', 'unique', 'targetClass' => '\shop\models\Customer', 'message' => 'This email address has already been taken.'],

			[['password','password_repeat'], 'required'],
			['password', 'string', 'min' => 6],
			['password', 'compare', 'compareAttribute' => 'password_repeat'],
		];
	}

	/**
	 * Signs user up.
	 *
	 * @return User|null the saved model or null if saving fails
	 */
	public function signup()
	{
		if (!$this->validate()) {
			return null;
		}
		
		$user = new Customer();
		$user->name = $this->name;
		$user->email = $this->email;
		$user->telephone = $this->telephone;
		$user->status = Customer::STATUS_ACTIVE;
		$user->setPassword($this->password);
		$user->generateAuthKey();

        $result = null;
        if ($user->save()) {
            Yii::$app->helper->sendRegistrationSuccessEmailToCustomer($user);
            Yii::$app->helper->sendRegistrationAlertEmailToAdmin($user);
            $result = $user;
        }
        return $result;
	}
}
