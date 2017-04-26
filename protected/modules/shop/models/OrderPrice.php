<?php

namespace shop\models;

use Yii;

/**
 * This is the model class for table "{{%shop_order_price}}".
 *
 * @property int $id
 * @property int $order_id
 * @property string $code
 * @property string $title
 * @property string $value
 *
 * @property Order $order
 */
class OrderPrice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_order_price}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'code', 'title'], 'required'],
            [['order_id'], 'integer'],
            [['value'], 'number'],
            [['code'], 'string', 'max' => 32],
            [['title'], 'string', 'max' => 255],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
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
            'code' => Yii::t('shop', 'Code'),
            'title' => Yii::t('shop', 'Title'),
            'value' => Yii::t('shop', 'Value'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }
}
