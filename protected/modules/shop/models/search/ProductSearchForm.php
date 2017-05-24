<?php

namespace shop\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use shop\models\Product;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class ProductSearchForm extends Model
{
	public $text;
	public $categoryId;
	public $inSubCategory;
	public $inDescription;

	/**
	 * @return array the validation rules.
	 */
	public function rules()
	{
		return [
			['text', 'safe'],
			[['categoryId', 'inSubCategory', 'inDescription'], 'integer'],
		];
	}

    public function formName() {
        return '';
    }

    public function getCategoryOptions() {
    	return \shop\models\Category::getCategoryOptions();
    }

	public function search() {
		$query = Product::find()
			->active()
			->instock()
			->visible();

		// if ($this->categoryId) {
		// 	$query->joinWith('categoryProducts');
		// 	if ($this->inSubCategory) {
		// 		$query->joinWith('categoryProducts');
		// 	}
		// }

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination'=>['defaultPageSize'=>Yii::$app->params['defaultPageSize']]
		]);
		return $dataProvider;
	}
}
