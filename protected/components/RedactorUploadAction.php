<?php

namespace app\components;

use Yii;

/**
 * upload action for redactor widget
 * 
 * @author Lam Huynh <hqlam.bt@gmail.com>
 * @link http://imperavi.com/redactor
 */
class RedactorUploadAction extends UploadAction {

	protected function saveUploadFile($file) {
		$h = Yii::$app->helper;
		$storagePath = $h->createPathForSave($h->getStoragePath('wyswyg/'.$file['name']));
		$storageUrl = $h->getStorageUrl('wyswyg/'.basename($storagePath));
		if ( !move_uploaded_file($file['tmp_name'], $storagePath) )
			throw new ServerErrorHttpException(Yii::t('app', 'Error saving file to server.'));
		return [
			'filelink'=>$storageUrl,
		];
	}
}
