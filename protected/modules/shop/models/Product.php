<?php

namespace shop\models;

use Yii;

/**
 * This is the model class for table "{{%shop_product}}".
 *
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keyword
 * @property string $quantity
 * @property integer $stock_status
 * @property integer $status
 * @property string $price
 * @property string $model
 * @property string $slug
 * @property string $viewed
 * @property string $created_at
 * @property string $updated_at
 * @property string $available_time
 *
 * @property CategoryProduct[] $shopCategoryProducts
 * @property Category[] $categories
 * @property ProductImage[] $shopProductImages
 */
class Product extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const STATUS_IN_STOCK = 1;
    const STATUS_OUT_OF_STOCK = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_product}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['quantity', 'stock_status', 'status', 'viewed'], 'integer'],
            [['price'], 'number'],
            [['created_at', 'updated_at', 'available_time'], 'safe'],
            [['name', 'meta_title', 'meta_description', 'meta_keyword', 'slug'], 'string', 'max' => 255],
            [['model'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop', 'ID'),
            'name' => Yii::t('shop', 'Name'),
            'description' => Yii::t('shop', 'Description'),
            'meta_title' => Yii::t('shop', 'Meta Title'),
            'meta_description' => Yii::t('shop', 'Meta Description'),
            'meta_keyword' => Yii::t('shop', 'Meta Keyword'),
            'quantity' => Yii::t('shop', 'Quantity'),
            'stock_status' => Yii::t('shop', 'Stock Status'),
            'status' => Yii::t('shop', 'Status'),
            'price' => Yii::t('shop', 'Price'),
            'model' => Yii::t('shop', 'Model'),
            'slug' => Yii::t('shop', 'Slug'),
            'viewed' => Yii::t('shop', 'Viewed'),
            'created_at' => Yii::t('shop', 'Create Time'),
            'updated_at' => Yii::t('shop', 'Update Time'),
            'available_time' => Yii::t('shop', 'Available Time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryProducts()
    {
        return $this->hasMany(CategoryProduct::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])->viaTable('{{%shop_category_product}}', ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductImages()
    {
        return $this->hasMany(ProductImage::className(), ['product_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \shop\models\query\ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \shop\models\query\ProductQuery(get_called_class());
    }

    public function getImageUrl($width=null, $height=null) {
        return Yii::$app->helper->getResizeUrl($this->image, $width, $height);
    }
    
    public function getUrl() {
        return Yii::$app->helper->getProductUrl($this->slug);
    }

    static public function getStockStatusOptions() {
        return [
            self::STATUS_IN_STOCK => Yii::t('shop', 'In Stock'),
            self::STATUS_OUT_OF_STOCK => Yii::t('shop', 'Out Of Stock'),
        ];
    }

    public function prependSlug($slug) {
        $s = trim($slug);
        if (!$s) return;
        $this->slug = $slug . '/' . $this->slug;
    }
}
