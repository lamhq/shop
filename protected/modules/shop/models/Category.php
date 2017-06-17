<?php

namespace shop\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%shop_category}}".
 *
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keyword
 * @property string $image
 * @property string $slug
 * @property integer $status
 * @property string $sort_order
 * @property string $parent_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Category $parent
 * @property Category[] $categories
 * @property CategoryProduct[] $CategoryProducts
 * @property Product[] $products
 */
class Category extends \yii\db\ActiveRecord
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
		return '{{%shop_category}}';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['description'], 'string'],
			[['status', 'sort_order', 'parent_id'], 'integer'],
			[['created_at', 'updated_at'], 'safe'],
			[['name', 'meta_title', 'meta_description', 'meta_keyword', 'image', 'slug'], 'string', 'max' => 255],
			[['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['parent_id' => 'id']],
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
			'image' => Yii::t('shop', 'Image'),
			'slug' => Yii::t('shop', 'Slug'),
			'status' => Yii::t('shop', 'Status'),
			'sort_order' => Yii::t('shop', 'Display Order'),
			'parent_id' => Yii::t('shop', 'Parent Category'),
			'created_at' => Yii::t('shop', 'Create Time'),
			'updated_at' => Yii::t('shop', 'Update Time'),
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getParent()
	{
		return $this->hasOne(Category::className(), ['id' => 'parent_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCategories()
	{
		return $this->hasMany(Category::className(), ['parent_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCategoryProducts()
	{
		return $this->hasMany(CategoryProduct::className(), ['category_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getProducts()
	{
		return $this->hasMany(Product::className(), ['id' => 'product_id'])->viaTable('{{%shop_category_product}}', ['category_id' => 'id']);
	}

	/**
	 * @inheritdoc
	 * @return \shop\models\query\CategoryQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new \shop\models\query\CategoryQuery(get_called_class());
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

	public function getImageUrl($width=null, $height=null) {
		return Yii::$app->helper->getResizeUrl($this->image, $width, $height);
	}
	
	/**
	 * @return string
	 */
	public function getUrl() {
		$s = $this->path ?: $this->slug;
		return Yii::$app->helper->getCategoryUrl($s);
	}

	static public function getAllCategories() {
		return Yii::$app->helper->getVar('shopCategories', function() {
			// return static::find()
			//     ->joinWith('categoryProducts')
			//     ->select([
			//         '{{%shop_category}}.*', 
			//         'count({{%shop_category_product}}.product_id) as productCount'
			//     ])
			//     ->groupBy(['{{%shop_category}}.id'])
			//     ->addOrderBy('sort_order ASC')
			//     ->all();
			return static::find()
				->addOrderBy('sort_order ASC')
				->all();
		});
	}

	/**
	 * recursively travel the category tree by parent category
	 * @param  callable  $callback A callback that will be called each time a category is found. signature: function handler ( $category, $level, $parent )
	 * @param  mixed  $parent   Category model or null
	 * @param  integer $level   starter depth level
	 */
	static public function travel($callback, $parent=null, $level=0) {
		foreach(self::getAllCategories() as $category) {
			$isActive = $category->status==self::STATUS_ACTIVE;
			$parentMatch = ($parent && $category->parent_id==$parent->id)
			 || (!$parent && $category->parent_id==null);
		  
			if ( $isActive && $parentMatch ) {
				$stop = $callback($category, $level, $parent);
				if (!$stop) self::travel($callback, $category, $level+1);
			}
		}
	}

	static public function getCategoryOptions($excludes=[]) {
		$result = [];
		self::travel(function ($category, $level) use (&$result, $excludes) {
			if ( in_array($category->id, $excludes) ) {
				return true;	// stop traveling
			} else {
				$k = (string)$category->id;
				$v = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level).$category->name;
				$result[$k] = $v;
				return false;
			}
		});
		return $result;
	}

	static public function getDescendants($parentId, $level) {
		$result = [];
		foreach (Category::getAllCategories() as $c) {
			if ($c->parent_id==$parentId) {
				$result[] = ['id'=>$c->id, 'level'=>$level, 'model'=>$c ];
				$result = array_merge($result, self::getDescendants($c->id, $level+1));
			}
		}
		return $result;
	}

	static public function getStatusOptions() {
		return [
			self::STATUS_ACTIVE => Yii::t('shop', 'Active'),
			self::STATUS_INACTIVE => Yii::t('shop', 'In-active'),
		];
	}
	
}
