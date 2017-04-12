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
 * @property string $shipping_city
 * @property string $shipping_district
 * @property string $shipping_ward
 * @property string $shipping_address
 * @property string $shipping_method
 * @property string $shipping_code
 * @property string $comment
 * @property string $total
 * @property int $status
 * @property string $create_time
 * @property string $update_time
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
            [['email'], 'email'],
            
            [['invoice_no', 'customer_id', 'status'], 'integer'],
            [['comment'], 'string'],
            [['total'], 'number'],
            [['create_time', 'update_time'], 'safe'],
            [['name'], 'string', 'max' => 64],
            [['email'], 'string', 'max' => 96],
            [['telephone', 'shipping_name'], 'string', 'max' => 32],
            [['payment_method', 'payment_code', 'shipping_city', 'shipping_district', 'shipping_ward', 'shipping_address', 'shipping_method', 'shipping_code'], 'string', 'max' => 128],
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
            'shipping_city' => Yii::t('shop', 'Shipping City'),
            'shipping_district' => Yii::t('shop', 'Shipping District'),
            'shipping_ward' => Yii::t('shop', 'Shipping Ward'),
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
     * @inheritdoc
     * @return \shop\models\query\OrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \shop\models\query\OrderQuery(get_called_class());
    }
}
