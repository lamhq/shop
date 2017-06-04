<?php

namespace shop\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use shop\models\Category;

class CategoryController extends Controller
{
	public function actionView($path)
	{
        $model = Category::find()->active()->bySlug($path)->one();
        if (!$model) {
            throw new NotFoundHttpException;
        }

        $model->path = $path;
		$this->registerMetaTags($model);
		$this->view->params['breadcrumbs'] = $this->buildBreadcrumbData($model);
		return $this->renderDynamic('view', [
			'model'=>$model,
			'dataProvider'=>$this->getDataProvider($model)
		]);
	}

	protected function renderDynamic($view, $params=[]) {
		if (Yii::$app->request->headers->has('X-Requested-With')) {
			return $this->renderPartial($view, $params);
		} else {
			return $this->render($view, $params);
		}
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
				'href' => $h->getCategoryUrl($model->slug)
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

	protected function getDataProvider($category) {
		$model = new \shop\models\search\Product();
		$model->categoryId = $category->id;
		return $model->search();
	}
}
