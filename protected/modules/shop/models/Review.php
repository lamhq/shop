<?php

namespace shop\models;

use Yii;

/**
 * This is the model class for table "{{%shop_review}}".
 *
 * @property int $id
 * @property int $product_id
 * @property int $customer_id
 * @property string $author
 * @property string $text
 * @property int $rating
 * @property int $status
 * @property string $create_time
 * @property string $update_time
 *
 * @property ShopProduct $product
 * @property ShopCustomer $customer
 */
class Review extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_review}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'author', 'text', 'rating', 'create_time', 'update_time'], 'required'],
            [['product_id', 'customer_id', 'rating', 'status'], 'integer'],
            [['text'], 'string'],
            [['create_time', 'update_time'], 'safe'],
            [['author'], 'string', 'max' => 64],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopProduct::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopCustomer::className(), 'targetAttribute' => ['customer_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop', 'ID'),
            'product_id' => Yii::t('shop', 'Product ID'),
            'customer_id' => Yii::t('shop', 'Customer ID'),
            'author' => Yii::t('shop', 'Author'),
            'text' => Yii::t('shop', 'Text'),
            'rating' => Yii::t('shop', 'Rating'),
            'status' => Yii::t('shop', 'Status'),
            'create_time' => Yii::t('shop', 'Create Time'),
            'update_time' => Yii::t('shop', 'Update Time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(ShopProduct::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(ShopCustomer::className(), ['id' => 'customer_id']);
    }

    /**
     * @inheritdoc
     * @return \shop\models\query\ReviewQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \shop\models\query\ReviewQuery(get_called_class());
    }
}
