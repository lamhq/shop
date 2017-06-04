<?php

namespace shop\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use shop\models\Category;
use shop\models\Review;
use shop\models\ReviewForm;

/**
 * @author Lam Huynh <lamhq.com>
 */
class ReviewController extends Controller
{
	public function actionIndex($productId) {
		$query = Review::find()
			->approved()
			->byProductId($productId)
			->orderBy('created_at');
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination'=>false
		]);
		return $this->renderPartial('_list', [
			'dataProvider' => $dataProvider
		]);
	}

	public function actionForm($productId) {
		$model = new ReviewForm();
		$model->customer_id = Yii::$app->user->id;
		$model->product_id = $productId;
		$model->status = Review::STATUS_PENDING;

		if ( $model->load(Yii::$app->request->post()) && $model->save() ) {
			$model->attributes = [
				'text' => '',
				'author' => '',
				'rating' => '',
				'verificationCode' => '',
			];
			Yii::$app->helper->setSuccess(Yii::t('shop', 'Thank you for your review. It has been submitted to the webmaster for approval.'));
		}

		return $this->renderPartial('_form', [
			'model' => $model
		]);
	}
}
