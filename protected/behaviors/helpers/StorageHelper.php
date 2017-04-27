<?php
namespace app\behaviors\helpers;

use yii;
use yii\base\Behavior;
use yii\helpers\Url;
use lamhq\php\helpers\ImageHelper;

/**
 * Provide file helper method for application level
 * 
 * @author Lam Huynh <lamhq.com>
 */
class StorageHelper extends Behavior {

	/**
	 * get image resize url base on relative file path in system
	 * @return string	empty string on failed
	 */
	public function getResizeUrl($relPath, $width, $height, $options=[]) {
		$srcPath = $this->getStoragePath($relPath);
		if ( !is_file($srcPath) )
			return $this->getNoImageUrl($width, $height);

		$parts = pathinfo($relPath);
		$p = sprintf('%s/%s-%sx%s.%s', $parts['dirname'], $parts['filename'], 
			$width, $height, $parts['extension']);

		$resizePath = $this->getTemporaryFilePath($p);
		$resizeUrl = $this->getTemporaryFileUrl($p);
		if (is_file($resizePath)) return $resizeUrl;

		$options = array_merge(['width'=>$width, 'height'=>$height], $options);
		$r = ImageHelper::resize($srcPath, $resizePath, $options);
		return $r ? $resizeUrl : $this->getNoImageUrl($width, $height);
	}

	public function getStorageUrl($path='') {
		$parts = [
			Url::base(true),
			Yii::$app->params['storagePath'],
			$path
		];
		return $this->normalizeFileUrl(implode('/', $parts));
	}

	public function getStoragePath($path='') {
		$parts = [
			Yii::getAlias('@webroot'),
			Yii::$app->params['storagePath'],
			$path
		];
		return implode(DIRECTORY_SEPARATOR, $parts);
	}

	public function getTemporaryFileUrl($path) {
		return Yii::getAlias(Yii::$app->assetManager->baseUrl).'/tmp/'.$path;
	}

	public function getTemporaryFilePath($path) {
		return Yii::getAlias(Yii::$app->assetManager->basePath).'/tmp/'.$path;
	}

	/**
	 * Create an unique filename for save from a file path
	 * @param  string $path absolute file path in system
	 * @return string       file path for save
	 */
	public function createPathForSave($path) {
		$parts = pathinfo($path);
		$i=1;
		while ( is_file($path) ) {
			$path = $parts['dirname'].DIRECTORY_SEPARATOR.$parts['filename'].$i.'.'.$parts['extension'];
			$i++;
		}
		if ( !file_exists(dirname($path)) )
			mkdir(dirname($path), 0777, true);
		return $path;
	}

	/**
	 * convert a url to use for download
	 * @param  string $url
	 * @return string
	 */
	protected function normalizeFileUrl($url) {
		return dirname($url).'/'.rawurlencode(basename($url));
	}

	protected function getNoImageUrl($width=null, $height=null) {
		$src = $this->getStoragePath('no-image.jpg');
		if ( !is_file($src) ) return 'http://placehold.it/230x200?text='.urlencode(Yii::$app->params['siteTitle']);

		$filename = "no-image-{$width}x{$height}.jpg";
		$dst = $this->getTemporaryFilePath($filename);
		$url = $this->getTemporaryFileUrl($filename);
		ImageHelper::resize($src, $dst, ['width'=>$width, 'height'=>$height]);
		return $url;
	}

}
