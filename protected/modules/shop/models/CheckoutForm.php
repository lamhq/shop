<?php

namespace shop\models;

use Yii;
use shop\components\CustomerCartItemCollection;

/**
 * model contains user checkout data
 */
class CheckoutForm extends Order
{
	const ADDRESS_TYPE_EXISTING = 'existing';
	const ADDRESS_TYPE_NEW = 'new';

	/**
	 * list of item in cart
	 * @var \shop\components\CartItemCollection
	 */
	public $itemCollection;

	/**
	 * whether to register account in step 1
	 * @var bool
	 */
	public $register;

	/**
	 * account model for registration
	 * @var SignupForm
	 */
	public $signupForm;

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
	 * address model for shipping address
	 * @var shop\models\Address
	 */
	public $shippingAddress;

	public function init() {
		$this->signupForm = new SignupForm();
		$this->shippingAddress = new Address([
			'scenario'=>$this->scenario
		]);
	}

	/**
	 * @return array the validation rules.
	 */
	public function rules() {
		$rules = parent::rules();
		return array_merge($rules,[
			// checkout as guest
			[['name', 'telephone'], 'required', 'on'=>'guestCheckout'],
			[['shippingAddress'], 'validateModel', 'on'=>'guestCheckout'],
			// validate registration form when user choose to register new account
			[['signupForm','email'], 'validateRegistration', 'on'=>'guestCheckout',
				'when'=>function($model) {
					return (bool)$model->register;
				}
			],

			// checkout with account
			[['shippingAddressType'], 'required', 'on'=>'accountCheckout'],
			// validate address form when user choose to create new address
			[['shippingAddress'], 'validateModel', 'on'=>'accountCheckout',
				'when'=>function($model) {
					return $model->shippingAddressType==self::ADDRESS_TYPE_NEW;
				}
			],

			[['payment_code'], 'required'],
			[['register', 'shippingAddressType', 'shippingAddressId'], 'integer'],
		]);
	}

	/**
	 * @return array
	 */
	public function fields()
	{
		$fields = parent::fields();
		return array_merge($fields, [
			'register',
			'shippingAddressType',
			'shippingAddressId',
		]);
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(), [
			'comment' => Yii::t('shop', 'Add comments about your order'),
		]);
	}

	public function setData($data) {
		$a = $this->load($data);
		$b = $this->signupForm->load($data);
		$c = $this->shippingAddress->load($data);
		return $a || $b || $c;
	}

	public function getData() {
		$shippingAddress = $this->shippingAddress;
		$signupForm = $this->signupForm;
		$address = $shippingAddress->formName();
		$result = [
			$this->formName() => $this->toArray(),
			$signupForm->formName() => $signupForm->toArray(),
			$address => $shippingAddress->toArray(),
		];

		// remove shipping address form data if use choose to use existing address
		if ($this->shippingAddressId) {
			unset($result[$address]);
		}
		return $result;
	}

	public function validateModel($attribute, $params, $validator) {
		$model = $this->$attribute;
		if (!$model->validate()) {
			$this->addError($attribute, 'Error when validating '.$attribute);
		}
	}

	public function validateRegistration($attribute, $params, $validator) {
		$signupForm = $this->$attribute;
		$signupForm->email = $this->email;
		$signupForm->name = $this->name;
		$signupForm->telephone = $this->telephone;
		if (!$signupForm->validate()) {
			if ($signupForm->hasErrors('email')) {
				$this->addError('email', $signupForm->getFirstError('email'));
			}
			if ($signupForm->hasErrors('name')) {
				$this->addError('name', $signupForm->getFirstError('name'));
			}
			if ($signupForm->hasErrors('telephone')) {
				$this->addError('telephone', $signupForm->getFirstError('telephone'));
			}
			$this->addError($attribute, Yii::t('shop', 'Registration input invalid.'));
		}
	}

	public function saveShippingGuest() {
		$this->shippingAddress->name = $this->name;
		if (!$this->validate()) return false;
		if ($this->register) {
			$customer = $this->signupForm->signup();
			$customer->addAddress($this->shippingAddress);
			Yii::$app->user->login($customer, 3600 * 24 * 30);
			$this->shippingAddressId = $customer->address_id;
			$this->customer_id = $customer->id;
		}
		return true;
	}

	public function saveShipping() {
		if (!$this->validate()) return false;
		if ($this->shippingAddressType==self::ADDRESS_TYPE_NEW) {
			$this->customer->addAddress($this->shippingAddress);
			$this->shippingAddressId = $this->shippingAddress->id;
			$this->shippingAddressType = 'existing';
		}
		return true;
	}

	public function setDefaultShippingAddress() {
		if ($this->customer && $this->customer->getAddressOptions()) {
			$this->shippingAddressType = self::ADDRESS_TYPE_EXISTING;
			$this->shippingAddressId = $this->customer->address_id;
		} else {
			$this->shippingAddressType = self::ADDRESS_TYPE_NEW;
		}
	}

	/**
	 * @return float
	 */
	public function getSubTotal() {
		$total = 0;
		foreach ($this->itemCollection->getItems() as $item) {
			$total += $item->getTotal();
		}
		return $total;
	}

	/**
	 * save order to database
	 * @return boolean
	 */
	public function placeOrder() {
		if (!$this->validate()) return false;
		return true;
	}

	/**
	 * get list of applied prices for cart
	 * @return array
	 */
	public function getPrices() {
		$prices = [];
		$total = 0;
		
		$prices[] = [
			'title'      => Yii::t('shop', 'Sub-Total'),
			'value'      => $this->getSubTotal(),
		];
		$total = $this->getSubTotal();

		$prices[] = [
			'title'      => Yii::t('shop', 'Total'),
			'value'      => max(0, $total),
		];

		return $prices;
	}

	/**
	 * get list of payment method
	 * @return array [ [code, title] ]
	 */
	public function getAvailablePaymentMethods() {
		$result = [];
		
		$result[] = [
			'title'     => 'Cash On Delivery',
			'code'      => 'cod',
		];

		return $result;
	}
}
