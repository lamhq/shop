<?php

namespace app\components;

use Yii;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;
use yii\base\Action;

class UploadAction extends Action {

	/**
	 * the param name in post request containt file field
	 * @var string
	 */
	public $fileIndex = 'file';

	public function run() {
		$response = [];
		$h = Yii::$app->helper;
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
		$storagePath = $h->createPathForSave($h->getTemporaryFilePath($file['name']));
		$filename = basename($storagePath);
		$storageUrl = $h->getTemporaryFileUrl($filename);
		if ( !move_uploaded_file($file['tmp_name'], $storagePath) )
			throw new ServerErrorHttpException(Yii::t('app', 'Error saving file to server.'));
		return [
			'value'=>$filename,
			'url'=>$storageUrl,
			'path'=>$storagePath,
			'label'=>$file['name'],
		];
	}

	protected function validateFileUpload($file) {
		// check allowed file types		
	}
}
