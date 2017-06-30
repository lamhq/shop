<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
	/**
	 * This command echoes what you have entered as the message.
	 * @param string $message the message to be echoed.
	 */
	public function actionIndex($message = 'hello world')
	{
		echo $message . "\n";
	}

	/**
	 * This command copy files from asset directory back to source code
	 */
	public function actionAsset()
	{
		$paths = [
			'assets/assets-public-63ddb47d/shop-frontend.js' => 
				'protected/modules/shop/assets/public/shop-frontend.js',
			
			'assets/assets-public-6602d939/common.js' => 
				'protected/assets/public/common.js',
			
			'assets/assets-public-aa0f3846/shop-backend.js' => 
				'protected/modules/shop/modules/manage/assets/public/shop-backend.js',
		];
		foreach($paths as $from => $to) {
			$src = realpath(Yii::getAlias('@app').'/../'.$from);
			$dst = realpath(Yii::getAlias('@app').'/../'.$to);
			copy($src, $dst);
			echo "copy $src to $dst\n";
		}
	}
}
