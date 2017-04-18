<?php

namespace shop\models;

use Yii;

/**
 * This is the model class for table "{{%shop_product_image}}".
 *
 * @property string $id
 * @property string $image
 * @property string $product_id
 * @property string $sort_order
 *
 * @property ShopProduct $product
 */
class ProductImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_product_image}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'sort_order'], 'integer'],
            [['image'], 'string', 'max' => 255],
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
            'image' => Yii::t('shop', 'Image'),
            'product_id' => Yii::t('shop', 'Product ID'),
            'sort_order' => Yii::t('shop', 'Sort Order'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getImageUrl($width=null, $height=null) {
        return Yii::$app->helper->getResizeUrl($this->image, $width, $height);
    }
    
}
