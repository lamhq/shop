<?php
namespace shop\modules\manage\models;

use Yii;
use shop\models\Category as BaseCategory;
use shop\models\CategoryRelation;

class Category extends BaseCategory
{
	/**
	 * image data being uploaded from client, format: [value, path, url]
	 * @var array
	 */
	public $uploadImage = [];

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return array_merge(parent::rules(), [
			[['uploadImage'], 'safe'],
			[['name'], 'required'],
		]);
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(), [
			'uploadImage' => Yii::t('shop', 'Image'),
		]);
	}

	public function getParentCategoryOptions() {
		return self::getCategoryOptions([$this->id]);
	}

	public function afterFind() {
		if ($this->image) {
			$this->uploadImage = [
				'value' => $this->image,
				'path' => Yii::$app->helper->getStoragePath($this->image),
				'url' => Yii::$app->helper->getStorageUrl($this->image),
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
		$this->saveImage();
		$this->reindex();
	}

	public function reindex() {
		CategoryRelation::generate();
	}

	public function saveImage() {
		$h = Yii::$app->helper;
		// save old image for removing later
		$oldImage = $this->image ? $h->getStoragePath($this->image) : null;

		// save upload image
		$item = &$this->uploadImage;
		$hasFileUpload = $item && is_array($item) && $item['path']!=$oldImage;
		$newValue = '';
		if ( $hasFileUpload ) {
			$value = 'shop/product/'.basename($item['value']);
			$path = $h->createPathForSave($h->getStoragePath($value));
			rename($item['path'], $path);
			// var_dump(sprintf('move %s to %s', $item['path'], $path));
			$item = [
				'value' => $value,
				'path' => $path,
			];
			$newValue = $item['value'];
		}

		// remove old image
		$hasCurrentImage = $this->image && is_file($oldImage);
		if ( $hasCurrentImage && $this->image!=$newValue ) {
			unlink($oldImage);
			// var_dump('remove file: '.$oldImage);
		}

		// update category image
		BaseCategory::updateAll(['image' => $newValue], 'id='.$this->id);
		$this->image = $newValue;
		// var_dump('update category.image='.$newValue);
	}
}
