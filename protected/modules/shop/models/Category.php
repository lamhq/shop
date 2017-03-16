<?php

namespace shop\models;

use Yii;
use yii\helpers\Html;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use app\helpers\StorageHelper;

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
     * number of product in category
     * @var int
     */
    public $productCount;

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
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'meta_title' => Yii::t('app', 'Meta Title'),
            'meta_description' => Yii::t('app', 'Meta Description'),
            'meta_keyword' => Yii::t('app', 'Meta Keyword'),
            'image' => Yii::t('app', 'Image'),
            'slug' => Yii::t('app', 'Slug'),
            'status' => Yii::t('app', 'Status'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'created_at' => Yii::t('app', 'Create Time'),
            'updated_at' => Yii::t('app', 'Update Time'),
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
                'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }

    public function getImageUrl($width=null, $height=null) {
        return StorageHelper::getResizeUrl($this->image, $width, $height);
    }
    
    /**
     * @return string
     */
    public function getUrl() {
        return \yii\helpers\Url::to(['/shop/category/view', 'slug'=>$this->slug]);
    }
}
