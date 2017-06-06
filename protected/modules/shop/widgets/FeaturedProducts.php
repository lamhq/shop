<?php
namespace shop\widgets;

use Yii;
use yii\base\Widget;
use yii\data\ActiveDataProvider;
use shop\models\Product;

class FeaturedProducts extends Widget
{
	/**
	 * Runs the widget.
	 */
	public function run()
	{
		$productIds = Yii::$app->params['featuredProducts'];
		$query = Product::find()
			->active()
			->visible()
			->andWhere(['in', 'id', $productIds]);
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination'=>false
		]);
		return $this->render('featuredProducts', [
			'dataProvider' => $dataProvider
		]);
	}

}
