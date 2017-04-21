<?php

namespace shop\models;

use Yii;

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
 * @property string $create_time
 * @property string $update_time
 *
 * @property Customer $customer
 * @property City $shippingCity
 * @property District $shippingDistrict
 * @property Ward $shippingWard
 */
class Order extends \yii\db\ActiveRecord
{
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
            [['create_time', 'update_time'], 'safe'],
            [['name'], 'string', 'max' => 64],
            [['email'], 'string', 'max' => 96],
            [['telephone', 'shipping_name'], 'string', 'max' => 32],
            [['payment_method', 'payment_code', 'shipping_address', 'shipping_method', 'shipping_code'], 'string', 'max' => 128],
            [['shipping_city_id', 'shipping_district_id', 'shipping_ward_id'], 'string', 'max' => 5],
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
            'id' => Yii::t('shop', 'ID'),
            'invoice_no' => Yii::t('shop', 'Invoice No'),
            'customer_id' => Yii::t('shop', 'Customer ID'),
            'name' => Yii::t('shop', 'Name'),
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
            'create_time' => Yii::t('shop', 'Create Time'),
            'update_time' => Yii::t('shop', 'Update Time'),
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
     * @inheritdoc
     * @return \shop\models\query\OrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \shop\models\query\OrderQuery(get_called_class());
    }
}
