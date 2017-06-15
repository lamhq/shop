<?php

namespace app\components;

use Yii;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;
use yii\base\Action;

class UploadAction extends Action {

	/**
	 * @var string
	 */
	public $fileIndex = 'ajax-file';

	public function run() {
		$response = [];
		$h = Yii::$app->helper;
		Yii::$app->controller->enableCsrfValidation = false;
		try {
			if ( !isset($_FILES[$this->fileIndex]) ) {
				throw new BadRequestHttpException(Yii::t('app', 'Invalid request.'));
			}

			$file = $_FILES[$this->fileIndex];
			if ($file['error'] > 0) {
				throw new ServerErrorHttpException(Yii::t('app', 'An error ocurred when uploading, code: {0}', $file['error']));
			}

			$this->validateFileUpload($file);
			return $h->jsonSuccess('', $this->saveUploadFile($file));
		} catch (Exception $ex) {
			return $h->jsonError($ex->getMessage());
		}
	}

	protected function saveUploadFile($file) {
		$h = Yii::$app->helper;
		$orgName = $file['name'];
		$filePath = $h->createPathForSave($h->getTemporaryFilePath($orgName));
		$filename = basename($filePath);
		$url = $h->getTemporaryFileUrl($filename);
		if ( !move_uploaded_file($file['tmp_name'], $filePath) )
			throw new CHttpException(500, 'Error saving file to server.');
		return [
			'value'=>$filename,
			'url'=>$url,
			'path'=>$filePath,
			'label'=>$orgName,
		];
	}

	protected function validateFileUpload($file) {
		// check allowed file types		
	}
}
