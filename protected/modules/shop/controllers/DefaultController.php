<?php

namespace shop\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use shop\models\LoginForm;
use shop\models\SignupForm;

class DefaultController extends Controller
{
	public function actionIndex()
	{
		return $this->redirect(['/shop/category/view', 'slug'=>'desktop']);
		return $this->render('index', [
		]);
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
            // $user = $model->signup();
            // if ($user) {
                // Yii::$app->getUser()->login($user);
                // if ($model->shouldBeActivated()) {
                //     Yii::$app->getSession()->setFlash('alert', [
                //         'body' => Yii::t(
                //             'frontend',
                //             'Your account has been successfully created. Check your email for further instructions.'
                //         ),
                //         'options' => ['class'=>'alert-success']
                //     ]);
                // } else {
                //     Yii::$app->getUser()->login($user);
                // }
                // return $this->goHome();
            // }
        }

        return $this->render('register', [
            'model' => $model
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
