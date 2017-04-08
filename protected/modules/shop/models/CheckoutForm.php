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
	 * @var string
	 */
	public $itemCollectionId;

	/**
	 * list of product in cart
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
	 * @var Address
	 */
	public $shippingAddress;

	public function init()
	{
		$this->itemCollection = new CustomerCartItemCollection([
			'collectionId'=>$this->itemCollectionId,
			'customerId'=>(int)$this->customer_id
		]);
		$this->signupForm = new SignupForm();
		$this->shippingAddress = new Address();
	}

	/**
	 * @return array the validation rules.
	 */
	public function rules()
	{
		return [
			[['name', 'telephone'], 'required', 'on'=>'shipping-guest'],
			[['shippingAddress'], 'validateModel', 'on'=>'shipping-guest'],
			// validate registration form when user choose to register new account
			[['signupForm'], 'validateRegistration', 'on'=>'shipping-guest',
				'when'=>function($model) {
					return (bool)$model->register;
				}
			],

			[['shippingAddressType'], 'required', 'on'=>'shipping'],
			// validate address form when user choose to create new address
			[['shippingAddress'], 'validateModel', 'on'=>'shipping',
				'when'=>function($model) {
					return $model->shippingAddressType==self::ADDRESS_TYPE_NEW;
				}
			],

			[['email'], 'email'],
			[['register', 'shippingAddressId'], 'integer'],
			[['name', 'telephone', 'email', 'shippingAddressType'], 'safe'],
		];
	}

	public function setData($data) {
		$a = $this->load($data);
		$b = $this->signupForm->load($data);
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
		}
		return true;
	}

	public function placeOrder() {
		if (!$this->validate()) return false;
	}

	/**
	 * get list of applied prices for cart
	 * @return array
	 */
	public function getPrices() {
		$totals = [];
		$total = 0;
		$totalData = [
			'totals' => &$totals,
			'total'  => &$total
		];

		$this->applySubTotalPrice($totalData);
		$this->applyTotalPrice($totalData);

		return $totals;
	}

	/**
	 * @return float
	 */
	public function getSubTotal() {
		$total = 0;
		foreach ($this->getItems() as $item) {
			$total += $item->getTotal();
		}
		return $total;
	}

	/**
	 * apply sub total price to price list
	 * @param  array $total
	 */
	protected function applySubTotalPrice($totalData) {
		$sub_total = $this->getSubTotal();

		$totalData['totals'][] = [
			'title'      => Yii::t('shop', 'Sub-Total'),
			'value'      => $sub_total,
		];

		$totalData['total'] += $sub_total;
	}

	/**
	 * apply total price to price list
	 * @param  array $total
	 */
	protected function applyTotalPrice($totalData) {
		$totalData['totals'][] = [
			'title'      => Yii::t('shop', 'Total'),
			'value'      => max(0, $totalData['total']),
		];
	}

}
