<?php
namespace shop\widgets;

use Yii;
use yii\data\ActiveDataProvider;
use shop\models\Product;

class FeaturedProductList extends ProductList
{
	public function init() {
		$productIds = [1,2,3,4];
		$query = Product::find()
			->andWhere(['in', 'id', $productIds]);
		$this->dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination'=>['defaultPageSize'=>Yii::$app->params['defaultPageSize']]
		]);
	}

	/**
	 * Runs the widget.
	 */
	public function run()
	{
		return parent::run();
	}

}
