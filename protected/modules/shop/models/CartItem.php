<?php

namespace shop\models;
use yii\behaviors\TimestampBehavior;

use Yii;

/**
 * This is the model class for table "{{%shop_cart}}".
 *
 * @property int $id
 * @property int $customer_id
 * @property string $session_id
 * @property int $product_id
 * @property int $quantity
 * @property string $added_at
 *
 * @property Product $product
 * @property Customer $customer
 */
class CartItem extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%shop_cart}}';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['customer_id', 'product_id', 'quantity'], 'integer'],
			[['added_at'], 'safe'],
			[['session_id'], 'string', 'max' => 32],
			[['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
			[['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => Yii::t('shop', 'ID'),
			'customer_id' => Yii::t('shop', 'Customer ID'),
			'session_id' => Yii::t('shop', 'Session ID'),
			'product_id' => Yii::t('shop', 'Product ID'),
			'quantity' => Yii::t('shop', 'Quantity'),
			'added_at' => Yii::t('shop', 'Added At'),
		];
	}

	/**
	 * @inheritdoc
	 * @return \shop\models\query\CartItemQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new \shop\models\query\CartItemQuery(get_called_class());
	}
   
	public function behaviors() { 
		return [ 
			[ 
				'class' => TimestampBehavior::className(), 
				'value' => new \yii\db\Expression('NOW()'), 
				'createdAtAttribute'=> 'added_at', 
				'updatedAtAttribute'=> false, 
			], 
		]; 
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getProduct()
	{
		return $this->hasOne(Product::className(), ['id' => 'product_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCustomer()
	{
		return $this->hasOne(ShopCustomer::className(), ['id' => 'customer_id']);
	}

	public function getUnitPrice() {
		return $this->product->price;
	}

	public function getTotal() {
		return $this->getUnitPrice() * $this->quantity;
	}

}
