<?php

namespace shop\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use shop\models\Product;
use shop\models\Category;
use shop\models\AddToCartForm;

/**
 * @author Lam Huynh <lamhq.com>
 */
class ProductController extends Controller
{
	/**
	 * @param $slug
	 * @return string
	 * @throws NotFoundHttpException
	 */
	public function actionView($slug)
	{
		$model = Product::find()
			->active()
			->instock()
			->visible()
			->bySlug($slug)
			->one();
		if (!$model) {
			throw new NotFoundHttpException;
		}

		$cart = new AddToCartForm([
			'productId' => $model->id,
			'qty' => 1
		]);

		$this->buildBreadcrumbData($slug);
		$this->addCanonicalTag($slug);
		return $this->render('view', [
			'model'=>$model,
			'cart'=>$cart
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
				$prod = Product::find()->bySlug($sl)->one();
				$result[] = $prod->name;
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
				'href' => $h->getProductUrl($h->normalizeSlug($slug))
			]);
		}
	}

	public function actionSearch() {
		$model = new \shop\models\search\ProductSearchForm();
		$model->load(Yii::$app->request->get());
		$dataProvider = $model->search();
		return $this->render('search', [
			'model' => $model,
			'dataProvider' => $dataProvider,
		]);
	}
}
