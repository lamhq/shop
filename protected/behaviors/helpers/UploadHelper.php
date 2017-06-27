<?php
namespace app\behaviors\helpers;

use Yii;
use yii\base\Behavior;
use yii\helpers\ArrayHelper;

class UploadHelper extends Behavior
{
	/**
	 * Init class attribute'value for file upload
	 *
	 * @param  string $sa	attribute name contain data for saving to database
	 * @param  string $ua	attribute name used for display upload widget in form
	 */
	public function initUploadAttribute($model, $sa, $ua) {
		$value = $model->$sa;
		$model->$ua = $value ? [
			'value' => $value,
			'path' => Yii::$app->helper->getStoragePath($value),
			'url' => Yii::$app->helper->getStorageUrl($value),
		] : [ 'value'=>'', 'path'=>'', 'url'=>'#'];
	}

	/**
	 * Save upload file to disk and update the new file name
	 *
	 * @param  string $sa       name of attribute contain file name for save
	 * @param  string $ua name of attribute contain client upload data
	 */
	public function saveUploadFile($model, $sa, $ua) {
		$h = Yii::$app->helper;
		$uploadData = &$model->$ua;
		$oldValue = $model->$sa;
		$oldPath = $oldValue ? $h->getStoragePath($oldValue) : null;

		// if user upload file, save file and update attribute
		if ( $uploadData && $uploadData['path']!=$oldPath ) {
			// set filename for saving
			$dn = dirname($oldValue);
			$pathPrefix = $dn=='.' ? '' : $dn;
			$bn = basename($uploadData['value']);
			$value = $pathPrefix ? $pathPrefix.'/'.$bn : $bn;
			$path = $h->createPathForSave($h->getStoragePath($value));
			rename($uploadData['path'], $path);
			// var_dump(sprintf('move %s to %s', $uploadData['path'], $path));

			// update attribute
			$uploadData = [
				'value' => $value,
				'path' => $path,
				'url' => Yii::$app->helper->getStorageUrl($value),
			];
			$model->$sa = $uploadData['value'];
		} elseif (!$uploadData) {
			// if no upload file, reset attribute
			$model->$sa = '';
		}

		// if 'no file upload' or 'new file is different 
		// with old file', remove old file
		if ( is_file($oldPath) && 
			(!$uploadData || $uploadData['path']!=$oldPath) ) {
			unlink($oldPath);
			// var_dump('remove file: '.$oldPath);
		}
	}

}