<?php

namespace shop\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class CheckoutForm extends Model
{
	const ADDRESS_EXISTING = 'existing';
	const ADDRESS_NEW = 'new';

	public $name;
	public $email;
	public $telephone;

	/**
	 * whether to register account in step 1
	 * @var bool
	 */
	public $register;

	/**
	 * account model for registration
	 * @var SignupForm
	 */
	public $account;

	/**
	 * address model for shipping address
	 * @var Address
	 */
	public $shippingAddress;

	/**
	 * use existed address or new
	 * @var bool
	 */
	public $shippingAddressType;

	/**
	 * Address id
	 * @var int
	 */
	public $shippingAddressId;

	/**
	 * customer model
	 * @var Customer
	 */
	public $customer;


	/**
	 * @return array the validation rules.
	 */
	public function rules()
	{
		return [
			[['name', 'telephone'], 'required', 'on'=>'shipping-guest'],
			[['shippingAddress'], 'validateModel', 'on'=>'shipping-guest'],
			// validate registration form when user choose to register new account
			[['account'], 'validateRegistration', 'on'=>'shipping-guest',
				'when'=>function($model) {
					return (bool)$model->register;
				}
			],

			[['shippingAddressType'], 'required', 'on'=>'shipping'],
			// validate address form when user choose to create new address
			[['shippingAddress'], 'validateModel', 'on'=>'shipping',
				'when'=>function($model) {
					return $model->shippingAddressType==self::ADDRESS_NEW;
				}
			],

			[['email'], 'email'],
			[['register', 'shippingAddressId'], 'integer'],
			[['name', 'telephone', 'email', 'shippingAddressType'], 'safe'],
		];
	}

	public function init()
	{
		$this->account = new SignupForm();
		$this->shippingAddress = new Address();
	}

	public function setData($data) {
		$a = $this->load($data);
		$b = $this->account->load($data);
		$c = $this->shippingAddress->load($data);
		return $a || $b || $c;
	}

	public function getData() {
		$shippingAddress = $this->shippingAddress;
		$shippingKey = $shippingAddress->formName();
		$result = [
			$this->formName() => $this->toArray(),
			$shippingKey => $shippingAddress->toArray(),
		];

		// remove shipping address form data if use choose to use existing address
		if ($this->shippingAddressId) {
			unset($result[$shippingKey]);
		}
		return $result;
	}

	public function validateModel($attribute, $params, $validator) {
		$model = $this->$attribute;
		if (!$model->validate()) {
			$this->addError($attribute, 'Error when validating '.$attribute);
		}
	}

	public function validateRegistration($attribute, $params, $validator)
	{
		$account = $this->$attribute;
		$account->email = $this->email;
		$account->name = $this->name;
		$account->telephone = $this->telephone;
		if (!$account->validate()) {
			if ($account->hasErrors('email')) {
				$this->addError('email', $account->getFirstError('email'));
			}
			if ($account->hasErrors('name')) {
				$this->addError('name', $account->getFirstError('name'));
			}
			if ($account->hasErrors('telephone')) {
				$this->addError('telephone', $account->getFirstError('telephone'));
			}
			$this->addError($attribute, Yii::t('shop', 'Registration input invalid.'));
		}
	}

	public function saveShippingGuest() {
		$this->shippingAddress->name = $this->name;
		if (!$this->validate()) return false;
		if ($this->register) {
			$customer = $this->account->signup();
			$customer->addAddress($this->shippingAddress);
			Yii::$app->user->login($customer, 3600 * 24 * 30);
			$this->shippingAddressId = $customer->address_id;
			$this->customer = $customer;
		}
		return true;
	}

	public function saveShipping() {
		if (!$this->validate()) return false;
		if ($this->shippingAddressType==self::ADDRESS_NEW) {
			$this->customer->addAddress($this->shippingAddress);
		}
		return true;
	}

	public function placeOrder() {
		if (!$this->validate()) return false;
	}

}
