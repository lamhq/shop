<?php

namespace shop\controllers;

use Yii;
use yii\helpers\Url;
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
	public function actionView($path)
	{
		$model = Product::find()
			->active()
			->instock()
			->visible()
			->bySlug($path)
			->one();
		if (!$model) {
			throw new NotFoundHttpException;
		}

		$cart = new AddToCartForm([
			'productId' => $model->id,
			'qty' => 1
		]);
        $model->path = $path;
		$this->registerMetaTags($model);
		$this->view->params['breadcrumbs'] = $this->buildBreadcrumbData($model);
		return $this->render('view', [
			'model'=>$model,
			'cart'=>$cart
		]);
	}

	protected function buildBreadcrumbData($model) {
		$slugs = explode('/', $model->path);
		$result = [];
		$parent = null;
		foreach ($slugs as $i => $slug) {
			if ( $i==count($slugs)-1 ) {
				$prod = $model;
				$result[] = $prod->name;
			} else {
				$cat = Category::find()->bySlug($slug)->one();
				if (!$cat) continue;

				$cat->path = $parent ? $parent->path.'/'.$cat->slug : $cat->slug;
				$result[] = [
					'label' => $cat->name, 
					'url' => $cat->getUrl(),
				];
				$parent = $cat;
			}
		}
		return $result;
	}

	protected function registerMetaTags($model) {
		$h = Yii::$app->helper;

		if ( strpos($model->path, '/')!==false ) {
			$this->view->registerLinkTag([
				'rel' => 'canonical', 
				'href' => $h->getProductUrl($model->slug)
			]);
		}

		$this->view->registerMetaTag([
			'name' => 'description',
			'content' => $model->meta_description,
		]);
		$this->view->registerMetaTag([
			'name' => 'keywords',
			'content' => $model->meta_keyword,
		]);
		$this->view->title = $h->getPageTitle($model->meta_title);
	}

	public function actionSearch() {
		$model = new \shop\models\search\Product();
		$params = Yii::$app->request->get();
		if ($params) {
			$this->view->registerLinkTag([
				'rel' => 'canonical', 
				'href' => Url::toRoute(['search']),
			]);
		}
		$model->load($params);

		$dataProvider = $model->search();
		return $this->render('search', [
			'model' => $model,
			'dataProvider' => $dataProvider,
		]);
	}
}
