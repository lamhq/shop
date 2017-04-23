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
			'scenario'=>$this->scenario,
		]);
		$this->setDefaultShippingAddress();
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
					return $this->shippingAddressType==self::ADDRESS_TYPE_NEW;
				}
			],
			[['shippingAddressId'], 'validateModel', 'on'=>'accountCheckout',
				'when'=>function($model) {
					return $this->shippingAddressType==self::ADDRESS_TYPE_EXISTING;
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

	public function setDefaultShippingAddress() {
		if ($this->customer) {
			if ($this->customer->getAddressOptions()) {
				$this->shippingAddressType = self::ADDRESS_TYPE_EXISTING;
				$this->shippingAddressId = $this->customer->address_id;
			} else {
				$this->shippingAddressType = self::ADDRESS_TYPE_NEW;
				$this->shippingAddress->name = $this->customer->name;
			}
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
	 * get list of applied prices for cart
	 * @return array
	 */
	public function getPrices() {
		$prices = [];
		$total = 0;

		$prices['subTotal'] = [
			'title'      => Yii::t('shop', 'Sub-Total'),
			'value'      => $this->getSubTotal(),
		];
		$total += $this->getSubTotal();

		$prices['total'] = [
			'title'      => Yii::t('shop', 'Total'),
			'value'      => max(0, $total),
		];

		return $prices;
	}

	/**
	 * get order final price
	 * @return double
	 */
	public function calculateTotal() {
		$prices = $this->getPrices();
		return $prices['total']['value'];
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

	/**
	 * save order to database
	 * @return boolean
	 */
	public function placeOrder() {
		if (!$this->validate()) return false;

		$transaction = Yii::$app->db->beginTransaction();
		try {
			$this->createCustomerAccount();
			$this->loadAddressData();
			$this->saveOrderRecord();
			$this->saveOrderProductRecords();
		    $transaction->commit();
		} catch(\Exception $e) {
		    $transaction->rollBack();
			throw $e;
		}
		return true;
	}

	private function loadAddressData() {
		// load address from existing address
		if ($this->customer_id) {
			if ($this->shippingAddressType==self::ADDRESS_TYPE_EXISTING
				&& $this->shippingAddress->isNewRecord) {
				$this->shippingAddress = Address::findOne($this->shippingAddressId);
			} elseif ($this->shippingAddressType==self::ADDRESS_TYPE_NEW) {
				$this->customer->addAddress($this->shippingAddress);
				$this->shippingAddressType = self::ADDRESS_TYPE_EXISTING;
				$this->shippingAddressId = $this->shippingAddress->id;
			}
		}
	}

	private function createCustomerAccount() {
		if ($this->register) {
			$customer = $this->signupForm->signup();
			Yii::$app->user->login($customer, 3600 * 24 * 30);
			$this->shippingAddress->name = $customer->name;
			$customer->addAddress($this->shippingAddress);
			$this->customer_id = $customer->id;
			$this->shippingAddressType = self::ADDRESS_TYPE_EXISTING;
			$this->shippingAddressId = $customer->address_id;
		}
	}
	
	private function saveOrderRecord() {
		// set order data from customer data
		if ($this->customer_id) {
			$this->name = $this->customer->name;
			$this->telephone = $this->customer->telephone;
			$this->email = $this->customer->email;
		}

		// save order record
		$this->shipping_name = $this->shippingAddress->name;
		$this->shipping_city_id = $this->shippingAddress->city_id;
		$this->shipping_district_id = $this->shippingAddress->district_id;
		$this->shipping_ward_id = $this->shippingAddress->ward_id;
		$this->shipping_address = $this->shippingAddress->address;
		$this->total = $this->calculateTotal();
		$this->save() || Yii::$app->helper->throwException('Error when saving order: '.json_encode($this->getFirstErrors()));
	}

	private function saveOrderProductRecords() {
		// save order product records
		foreach ($this->itemCollection->getItems() as $item) {
			$orderProd = new OrderProduct([
				'order_id' => $this->id,
				'product_id' => $item->product_id,
				'quantity' => $item->quantity,
				'price' => $item->product->price,
				'total' => $item->product->price*$item->quantity,
				'name' => $item->product->name,
				'model' => $item->product->model,
			]);
			$orderProd->save() || Yii::$app->helper->throwException('Error when saving order product: '.json_encode($orderProd->getFirstErrors()));
		}
	}

}
