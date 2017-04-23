<?php

namespace shop\models;

use Yii;

/**
 * This is the model class for table "{{%shop_order_product}}".
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property string $name
 * @property string $model
 * @property int $quantity
 * @property string $price
 * @property string $total
 * @property string $tax
 *
 * @property Order $order
 * @property Product $product
 */
class OrderProduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_order_product}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'product_id', 'quantity'], 'integer'],
            [['price', 'total', 'tax'], 'number'],
            [['name'], 'string', 'max' => 255],
            [['model'], 'string', 'max' => 64],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop', 'ID'),
            'order_id' => Yii::t('shop', 'Order ID'),
            'product_id' => Yii::t('shop', 'Product ID'),
            'name' => Yii::t('shop', 'Name'),
            'model' => Yii::t('shop', 'Model'),
            'quantity' => Yii::t('shop', 'Quantity'),
            'price' => Yii::t('shop', 'Price'),
            'total' => Yii::t('shop', 'Total'),
            'tax' => Yii::t('shop', 'Tax'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
