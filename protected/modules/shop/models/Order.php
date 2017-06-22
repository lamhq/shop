<?php

namespace shop\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%shop_order}}".
 *
 * @property int $id
 * @property int $invoice_no
 * @property int $customer_id
 * @property string $name
 * @property string $email
 * @property string $telephone
 * @property string $payment_method
 * @property string $payment_code
 * @property string $shipping_name
 * @property string $shipping_city_id
 * @property string $shipping_district_id
 * @property string $shipping_ward_id
 * @property string $shipping_address
 * @property string $shipping_method
 * @property string $shipping_code
 * @property string $comment
 * @property string $total
 * @property int $status
 * @property string $ip
 * @property string $user_agent
 * @property string $accept_language
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Customer $customer
 * @property City $shippingCity
 * @property District $shippingDistrict
 * @property Ward $shippingWard
 * @property OrderHistory[] $shopOrderHistories
 * @property OrderPrice[] $shopOrderPrices
 * @property OrderProduct[] $shopOrderProducts
 */
class Order extends \yii\db\ActiveRecord
{
	const STATUS_PENDING = 1;
	const STATUS_PROCESSING = 2;
	const STATUS_SHIPPED = 3;
	const STATUS_COMPLETE = 5;
	const STATUS_CANCELED = 7;
	const STATUS_REFUNDED = 11;

	const EVENT_COLLECT_PRICE = 'collectPrice';
	const EVENT_COLLECT_PAYMENT_METHOD = 'collectPaymentMethod';

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%shop_order}}';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['invoice_no', 'customer_id', 'status'], 'integer'],
			[['comment'], 'string'],
			[['total'], 'number'],
			[['created_at', 'updated_at'], 'safe'],
			[['name'], 'string', 'max' => 64],
			[['email'], 'string', 'max' => 96],
			[['telephone', 'shipping_name'], 'string', 'max' => 32],
			[['payment_method', 'payment_code', 'shipping_address', 'shipping_method', 'shipping_code'], 'string', 'max' => 128],
			[['shipping_city_id', 'shipping_district_id', 'shipping_ward_id'], 'string', 'max' => 5],
			[['ip'], 'string', 'max' => 40],
			[['user_agent', 'accept_language'], 'string', 'max' => 255],
			[['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
			[['shipping_city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['shipping_city_id' => 'id']],
			[['shipping_district_id'], 'exist', 'skipOnError' => true, 'targetClass' => District::className(), 'targetAttribute' => ['shipping_district_id' => 'id']],
			[['shipping_ward_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ward::className(), 'targetAttribute' => ['shipping_ward_id' => 'id']],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => Yii::t('shop', 'Order ID'),
			'invoice_no' => Yii::t('shop', 'Invoice No'),
			'customer_id' => Yii::t('shop', 'Customer ID'),
			'name' => Yii::t('shop', 'Customer'),
			'email' => Yii::t('shop', 'Email'),
			'telephone' => Yii::t('shop', 'Telephone'),
			'payment_method' => Yii::t('shop', 'Payment Method'),
			'payment_code' => Yii::t('shop', 'Payment Code'),
			'shipping_name' => Yii::t('shop', 'Shipping Name'),
			'shipping_city_id' => Yii::t('shop', 'Shipping City ID'),
			'shipping_district_id' => Yii::t('shop', 'Shipping District ID'),
			'shipping_ward_id' => Yii::t('shop', 'Shipping Ward ID'),
			'shipping_address' => Yii::t('shop', 'Shipping Address'),
			'shipping_method' => Yii::t('shop', 'Shipping Method'),
			'shipping_code' => Yii::t('shop', 'Shipping Code'),
			'comment' => Yii::t('shop', 'Comment'),
			'total' => Yii::t('shop', 'Total'),
			'status' => Yii::t('shop', 'Status'),
			'ip' => Yii::t('shop', 'Ip'),
			'user_agent' => Yii::t('shop', 'User Agent'),
			'accept_language' => Yii::t('shop', 'Accept Language'),
			'created_at' => Yii::t('shop', 'Create Time'),
			'updated_at' => Yii::t('shop', 'Update Time'),
			'numberOfProducts' => Yii::t('shop', 'No. of Products'),
			'displayStatus' => Yii::t('shop', 'Status'),
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCustomer()
	{
		return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getShippingCity()
	{
		return $this->hasOne(City::className(), ['id' => 'shipping_city_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getShippingDistrict()
	{
		return $this->hasOne(District::className(), ['id' => 'shipping_district_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getShippingWard()
	{
		return $this->hasOne(Ward::className(), ['id' => 'shipping_ward_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getOrderHistories()
	{
		return $this->hasMany(OrderHistory::className(), ['order_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getOrderPrices()
	{
		return $this->hasMany(OrderPrice::className(), ['order_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getOrderProducts()
	{
		return $this->hasMany(OrderProduct::className(), ['order_id' => 'id']);
	}

	/**
	 * @inheritdoc
	 * @return \shop\models\query\OrderQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new \shop\models\query\OrderQuery(get_called_class());
	}

	public function behaviors() {
		return [
			[
				'class' => TimestampBehavior::className(),
				'value' => function ($event) {
					return Yii::$app->formatter->asDbDateTime();
				},
			],
		];
	}

	public function addOrderHistory($status) {
		$oldStatus = $this->status;
		// If current order status is not processing or complete but new status is processing or complete then commence completing the order

			// Stock subtraction

		// Update the DB with the new statuses
		$this->status = $status;
		$this->update(false, ['status']);

		$oh = new OrderHistory([
			'order_id' => $this->id,
			'status' => $status,
		]);
		$oh->save();


		// If order status is null then becomes not null,
		// send new order email to customer and admin
		if (!$oldStatus && $status) {
			Yii::$app->helper->sendNewOrderMailToCustomer($this);
			Yii::$app->helper->sendNewOrderMailToAdmin($this);
		}

		// If order status is not null then,
		// send order status alert email to customer
		if ($oldStatus && $status) {
		}
	}

	public function getCustomerViewLink() {
		return Yii::$app->helper->getCustomerOrderUrl($this->id);
	}

	static public function getStatuses() {
		return self::getStatusOptions();
	}
	
	static public function getStatusOptions() {
		return [
			self::STATUS_PENDING => Yii::t('shop', 'Pending'),
			self::STATUS_PROCESSING => Yii::t('shop', 'Processing'),
			self::STATUS_SHIPPED => Yii::t('shop', 'Shipped'),
			self::STATUS_COMPLETE => Yii::t('shop', 'Complete'),
			self::STATUS_CANCELED => Yii::t('shop', 'Cancelled'),
			self::STATUS_REFUNDED => Yii::t('shop', 'Refunded'),
		];
	}
	
	static public function getStatusText($status) {
		return \yii\helpers\ArrayHelper::getValue(self::getStatusOptions(), $status);
	}

	public function getDisplayStatus() {
		return self::getStatusText($this->status);
	}
	
    public function getNumberOfProducts() {
    	$result = 0;
        foreach ($this->orderProducts as $item) {
        	$result += $item->quantity;
        }
        return $result;
    }
}
