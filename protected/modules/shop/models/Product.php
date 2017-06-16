<?php

namespace shop\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;

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
 * @property integer $rating
 * @property integer $status
 * @property string $price
 * @property string $model
 * @property string $slug
 * @property string $viewed
 * @property string $created_at
 * @property string $updated_at
 * @property string $available_time
 *
 * @property CategoryProduct[] $categoryProducts
 * @property Category[] $categories
 * @property ProductImage[] $productImages
 * @property Review[] $reviews
 */
class Product extends \yii\db\ActiveRecord
{
	const STATUS_ACTIVE = 1;
	const STATUS_INACTIVE = 0;

	/**
	 * category path used to create pretty url
	 * @var string
	 */
	public $path;

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
            [['quantity', 'rating', 'status', 'viewed'], 'integer'],
            [['price'], 'number'],
            [['created_at', 'updated_at', 'available_time'], 'safe'],
            [['name', 'short_description', 'image', 'meta_title', 'meta_description', 'meta_keyword', 'slug'], 'string', 'max' => 255],
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
			'name' => Yii::t('shop', 'Product Name'),
			'description' => Yii::t('shop', 'Description'),
			'meta_title' => Yii::t('shop', 'Meta Title'),
			'meta_description' => Yii::t('shop', 'Meta Description'),
			'meta_keyword' => Yii::t('shop', 'Meta Keyword'),
			'quantity' => Yii::t('shop', 'Stock Quantity'),
			'rating' => Yii::t('shop', 'Rating'),
			'status' => Yii::t('shop', 'Status'),
			'price' => Yii::t('shop', 'Price'),
			'model' => Yii::t('shop', 'Model'),
			'slug' => Yii::t('shop', 'Slug'),
			'viewed' => Yii::t('shop', 'Viewed'),
			'created_at' => Yii::t('shop', 'Create Time'),
			'updated_at' => Yii::t('shop', 'Update Time'),
			'available_time' => Yii::t('shop', 'Available Date'),
			'image' => Yii::t('shop', 'Image'),
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
	 * @return \yii\db\ActiveQuery 
	 */ 
	public function getReviews() 
	{ 
		return $this->hasMany(Review::className(), ['product_id' => 'id']);
	}

	/** 
	 * @return \yii\db\ActiveQuery 
	 */ 
	public function getApprovedReviews() 
	{ 
		return $this->getReviews()->approved();
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
		$s = $this->path ?: $this->slug;
		return Yii::$app->helper->getProductUrl($s);
	}

	public function getStockStatusText() {
		return $this->isOutOfStock() ? Yii::t('shop', 'Out Of Stock') : Yii::t('shop', 'In Stock');
	}

	public function isOutOfStock() {
		return $this->quantity <= 0;
	}
	
	static public function getStatusOptions() {
		return [
			self::STATUS_ACTIVE => Yii::t('shop', 'Active'),
			self::STATUS_INACTIVE => Yii::t('shop', 'In-active'),
		];
	}
	
	public function behaviors() {
		return [
			[
				'class' => SluggableBehavior::className(),
				'attribute' => 'name',
			],
			[
				'class' => TimestampBehavior::className(),
				'value' => function ($event) {
					return Yii::$app->formatter->asDbDateTime();
				},
			],
		];
	}

}
