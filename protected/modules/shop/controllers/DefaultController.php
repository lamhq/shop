<?php

namespace shop\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use shop\models\LoginForm;
use shop\models\SignupForm;
use shop\models\PasswordResetRequestForm;
use shop\models\ResetPasswordForm;

class DefaultController extends Controller
{
	public function actionIndex()
	{
		$this->registerHomepageMetaTags();
		return $this->render('index');
	}

	protected function registerHomepageMetaTags() {
		if (Yii::$app->request->pathInfo!='') {
			$this->view->registerLinkTag([
				'rel' => 'canonical', 
				'href' => Yii::$app->homeUrl
			]);
		}
		$params = Yii::$app->params;
		$this->view->registerMetaTag([
			'name' => 'description',
			'content' => $params['metaDescription'],
		]);
		$this->view->registerMetaTag([
			'name' => 'keywords',
			'content' => $params['metaKeyword'],
		]);
		$this->view->title = $params['metaTitle'];
	}

	/**
	 * Logs in a user.
	 *
	 * @return mixed
	 */
	public function actionLogin()
	{
		if (!Yii::$app->user->isGuest) {
			return $this->goHome();
		}

		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			return $this->goBack();
		} else {
			return $this->render('login', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Logs out the current user.
	 *
	 * @return mixed
	 */
	public function actionLogout()
	{
		Yii::$app->user->logout();
		return $this->goHome();
	}

	/**
	 * @return string|Response
	 */
	public function actionRegister()
	{
		$model = new SignupForm();
		if ($model->load(Yii::$app->request->post())) {
			$user = $model->signup();
			if ($user) {
				Yii::$app->getUser()->login($user);
				Yii::$app->helper->setSuccess(Yii::t('app', 'Your account has been successfully created.'));
				return $this->goHome();
			}
		}

		return $this->render('register', [
			'model' => $model
		]);
	}

	/**
	 * Requests password reset.
	 *
	 * @return mixed
	 */
	public function actionRequestPasswordReset()
	{
		$model = new PasswordResetRequestForm();
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$model->sendEmail();
			Yii::$app->helper->setSuccess(Yii::t('app', 'If there is an account associated with this information you will receive an email with a link to reset your password.'));
			return $this->refresh();
		}

		return $this->render('requestPasswordReset', [
			'model' => $model,
		]);
	}

	/**
	 * Resets password.
	 *
	 * @param string $token
	 * @return mixed
	 * @throws BadRequestHttpException
	 */
	public function actionResetPassword($token)
	{
		try {
			$model = new ResetPasswordForm($token);
		} catch (InvalidParamException $e) {
			throw new BadRequestHttpException($e->getMessage());
		}

		if ( $model->load(Yii::$app->request->post()) 
			&& $model->validate() && $model->resetPassword() ) {
			Yii::$app->session->setFlash('success', Yii::t('app', 'New password saved.') );
			return $this->goHome();
		}

		return $this->render('resetPassword', [
			'model' => $model,
		]);
	}

	public function actionDistricts($city) {
		$data = \shop\models\District::getDistrictOptions($city);
		$districts = [];
		foreach ($data as $value => $label) {
			$districts[] = ['value'=>$value, 'label'=>$label];
		}
		return Yii::$app->helper->jsonSuccess('', ['districts'=>$districts]);
	}

	public function actionWards($district) {
		$data = \shop\models\Ward::getWardOptions($district);
		$wards = [];
		foreach ($data as $value => $label) {
			$wards[] = ['value'=>$value, 'label'=>$label];
		}
		return Yii::$app->helper->jsonSuccess('', ['wards'=>$wards]);
	}
}
