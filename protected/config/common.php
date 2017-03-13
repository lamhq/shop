<?php
$result = [
	'vendorPath' => __DIR__ . '/../../vendor',
	'basePath' => dirname(__DIR__),
	'bootstrap' => ['log'],
	'language'=>'vi-VN',
	'sourceLanguage'=>'en-US',
	'params' => [
		'adminEmail' => 'admin@example.com',
		'supportEmail' => 'support@example.com',
		'user.passwordResetTokenExpire' => 3600,
	],
	'components' => [
		'db' => [
			'class' => 'yii\db\Connection',
			'dsn' => 'mysql:host=localhost;dbname=bookingcar_vn',
			'username' => 'root',
			'password' => 'root',
			'charset' => 'utf8',
		],
		'mailer' => [
			'class' => 'yii\swiftmailer\Mailer',
			'viewPath' => '@app/mail',
			// send all mails to a file by default. You have to set
			// 'useFileTransport' to false and configure a transport
			// for the mailer to send real emails.
			'useFileTransport' => true,
		],
		'i18n' => [
			'translations' => [
			],
		],
		'cache' => [
			'class' => 'yii\caching\FileCache',
		],
		'log' => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
			],
		],
	],
];

// merge module's configuration
$mp = realpath(__DIR__ . '/../modules');
$modules = scandir($mp);
foreach ($modules as $module) {
	$configFile = sprintf('%s/%s/config.php', $mp, $module);
	if (is_dir($mp.'/'.$module) && !in_array($module, ['.', '..']) 
		&& is_file($configFile)) {
		$result = array_merge_recursive($result, include($configFile));
	}
}

return $result;