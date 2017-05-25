<?php

namespace shop\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use shop\models\Category;
use shop\models\search\Product;

class CategoryController extends Controller
{
	public function actionView($slug)
	{
        $model = Category::find()->active()->bySlug($slug)->one();
        if (!$model) {
            throw new NotFoundHttpException;
        }

		$this->addCanonicalTag($slug);
		$this->view->params['breadcrumbs'] = $this->buildBreadcrumbData($slug);
		return $this->render('view', [
			'model'=>$model,
			'dataProvider'=>$this->getDataProvider($model)
		]);
	}

	protected function buildBreadcrumbData($slug) {
		$slugs = explode('/', $slug);
		$result = [];
		$parentCat = null;
		foreach ($slugs as $i => $sl) {
			$cat = Category::find()->bySlug($sl)->one();
			if (!$cat) continue;

			if ($parentCat) {
				$cat->prependSlug($parentCat->slug);
			}

			if ( $i==count($slugs)-1 ) {
				$result[] = $cat->name;
			} else {
				$result[] = [
					'label' => $cat->name, 
					'url' => $cat->getUrl(),
				];
			}
			$parentCat = $cat;
		}
		return $result;
	}

	protected function addCanonicalTag($slug) {
		if ( strpos($slug, '/')!==false ) {
			$h = Yii::$app->helper;
			$this->view->registerLinkTag([
				'rel' => 'canonical', 
				'href' => $h->getCategoryUrl($h->normalizeSlug($slug))
			]);
		}
	}

	protected function getDataProvider($category) {
		$model = new Product();
		$model->categoryId = $category->id;
		$dataProvider =$model->search();
		foreach ($dataProvider->getModels() as $product) {
			$product->prependSlug($category->slug);
		}
		return $dataProvider;
	}
}
