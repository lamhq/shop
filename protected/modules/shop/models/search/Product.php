<?php

namespace shop\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class Product extends Model
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

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'inDescription' => Yii::t('shop', 'In Description'),
			'inSubCategory' => Yii::t('shop', 'In Sub Category'),
		];
	}

    public function formName() {
        return '';
    }

    /**
     * @return array
     */
    public function getCategoryOptions() {
    	return \shop\models\Category::getCategoryOptions();
    }

	/**
	 * @return yii\data\ActiveDataProvider
	 */
	public function search() {
		$query = \shop\models\Product::find()
			->active()
			->visible();

		$this->addTextFilter($query);
		$this->addCategoryFilter($query);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination'=>['defaultPageSize'=>Yii::$app->params['defaultPageSize']]
		]);
		return $dataProvider;
	}

	/**
	 * append text filter to query
	 * @param \yii\db\ActiveQuery $query
	 */
	protected function addTextFilter($query) {
		$words = array_filter(preg_split('/\s+/', $this->text));
		if (!$words) return;

		if ($this->inDescription) {
			$condition = ['or'];
			$condition[] = $this->buildWordCondition('name', $words);
			$condition[] = $this->buildWordCondition('short_description', $words);
			$condition[] = $this->buildWordCondition('description', $words);
		} else {
			$condition = $this->buildWordCondition('name', $words);
		}

		$query->andWhere($condition);
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

	protected function addCategoryFilter($query) {
		if (!$this->categoryId) return;

		$query->innerJoinWith('categoryProducts cp', true);
		if ($this->inSubCategory) {
			$query->innerJoin('{{%shop_category_relation}} cr', 'cp.category_id=cr.descendant_id');
			$query->andWhere(['cr.ancestor_id'=>$this->categoryId]);
		} else {
			$query->andWhere(['cp.category_id'=>$this->categoryId]);
		}
	}
}
