<?php
namespace shop\modules\manage\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use app\behaviors\DateFormatConvertBehavior;
use shop\models\Category;
use shop\models\Product as BaseProduct;
use shop\models\ProductImage;

class Product extends BaseProduct
{
	/**
	 * for search
	 */
	public $categoryId;

	/**
	 * list of category's ids assigned to this model
	 */
	public $categoryIds = [];

	/**
	 * list of images belong to this product in array: [value, path, url]
	 * @var array
	 */
	public $imageItems = [];

	public function behaviors() {
		$h = Yii::$app->helper;
		return array_merge(parent::behaviors(), [
			[
				'class' => DateFormatConvertBehavior::className(),
				'attributes'=> ['available_time'],
				'displayFormat'=>$h->getDateFormat('php'),
				'storageFormat'=>$h->getDateFormat('db'),
			],
		]);
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return array_merge(parent::rules(), [
			[['categoryIds','imageItems'], 'safe', 'on'=>['insert','update']],
			[['name'], 'required', 'on'=>['insert','update']],
			[['name', 'price', 'status', 'categoryId'], 'safe', 'on'=>'search'],
		]);
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(), [
			'categoryId' => Yii::t('shop', 'Category'),
			'categoryIds' => Yii::t('shop', 'Categories'),
			'imageItems' => Yii::t('shop', 'Images'),
		]);
	}

	/**
	 * Creates data provider instance with search query applied
	 * @return ActiveDataProvider
	 */
	public function search($params)
	{
		$query = BaseProduct::find();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$this->addNameFilter($query);
		$this->addCategoryFilter($query);
		$query->andFilterWhere([
			'price'=>$this->price,
			'status'=>$this->status,
		]);
		return $dataProvider;
	}

	public function getCategoryOptions() {
		$result = [];
		Category::travel(function ($category, $level) use (&$result) {
			$k = (string)$category->id;
			$v = $category->name;
			$result[$k] = $v;
		});
		return $result;
	}

	/**
	 * append text filter to query
	 * @param \yii\db\ActiveQuery $query
	 */
	protected function addNameFilter($query) {
		$words = array_filter(preg_split('/\s+/', $this->name));
		if (!$words) return;

		$condition = $this->buildWordCondition('name', $words);
		$query->andFilterWhere($condition);
	}

	protected function addCategoryFilter($query) {
		if (!$this->categoryId) return;

		$query->innerJoinWith('categoryProducts cp', true);
		$query->andFilterWhere(['cp.category_id'=>$this->categoryId]);
	}

	/**
	 * build condition data for text search used in where clause
	 * @param  string $column
	 * @param  array $words
	 * @return array
	 */
	protected function buildWordCondition($column, $words) {
		if (!is_array($words) || !$words) return [];

		if (count($words)==1)
			return ['like', $column, $words[0]];

		$result = ['and'];
		foreach ($words as $s) {
			$result[] = ['like', $column, $s];
		}
		return $result;
	}

	public function afterFind() {
		$this->categoryIds = ArrayHelper::getColumn($this->categories, 'id');
		foreach ($this->productImages as $model) {
			$this->imageItems[] = [
				'value' => $model->image,
				'path' => Yii::$app->helper->getStoragePath($model->image),
				'url' => Yii::$app->helper->getStorageUrl($model->image),
			];
		}
	}

	public function beforeSave($insert)
	{
		if (!parent::beforeSave($insert)) {
			return false;
		}

		if (!$this->meta_title) {
			$this->meta_title = $this->name;
		}
		return true;
	}

	public function afterSave( $insert, $changedAttributes ) {
		$this->saveCategories();
		$this->saveImages();
	}

	public function saveCategories() {
		$this->unlinkAll('categories',true);
		if ( !is_array($this->categoryIds) ) return;
		foreach ($this->categoryIds as $catId) {
			$model = Category::findOne($catId);
			$this->link('categories', $model);
		}
	}

	public function saveImages() {
		$h = Yii::$app->helper;
		// save old image list before removing all existing records
		$oldImages = [];
		foreach ($this->productImages as $model) {
			$oldImages[] = $h->getStoragePath($model->image);
		}

		$this->unlinkAll('productImages',true);
		// var_dump('remove all product image record');

		// save upload images
		$newImages = [];
		$featuredImage = '';
		if (is_array($this->imageItems)) {
			$this->imageItems = array_values($this->imageItems);
			foreach ($this->imageItems as $i => &$item) {
				// move images from temporary directory to storage directory
				if ( !in_array($item['path'], $oldImages) ) {
					$value = 'shop/product/'.basename($item['value']);
					$path = $h->createPathForSave($h->getStoragePath($value));
					rename($item['path'], $path);
					// var_dump(sprintf('move %s to %s', $item['path'], $path));
					$item = [
						'value' => $value,
						'path' => $path,
					];
				}

				// collect new images
				$newImages[] = $item['path'];
				
				// save image relation
				$model = new ProductImage([
					'image' => $item['value'],
					'product_id' => $this->id,
				]);
				$model->save();
				// var_dump('save image record: '.$item['value']);
				
				// save the first image in list as featured image
				if ($i==0) {
					$featuredImage = $item['value'];
				}
			}
		}

		// remove unused images
		$removeImages = array_diff($oldImages, $newImages);
		foreach ($removeImages as $file) {
			if (is_file($file)) unlink($file);
			// var_dump('remove file: '.$file);
		}

		// update main image
		BaseProduct::updateAll(['image' => $featuredImage], 'id='.$this->id);
	}
}
