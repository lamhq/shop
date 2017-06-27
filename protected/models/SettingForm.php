<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Login form
 */
class SettingForm extends Model
{
	public $siteName;
	public $adminEmail;
	public $telephone;
	public $logo;
	public $favicon;
	public $metaTitle;
	public $metaKeyword;
	public $metaDescription;
	public $mailProtocol;
	public $mailSmtpHost;
	public $mailSmtpUser;
	public $mailSmtpPassword;
	public $mailSmtpPort;

	public $uploadLogo;
	public $uploadIcon;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['siteName', 'adminEmail', 'telephone', 'metaTitle'], 'required'],
			[['metaKeyword','metaDescription','mailProtocol','mailSmtpHost','mailSmtpUser','mailSmtpPassword','mailSmtpPort'], 'string'],
			[['uploadLogo','uploadIcon'], 'safe'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'siteName' => Yii::t('app', 'Site Name'),
			'adminEmail' => Yii::t('app', 'Email'),
			'telephone' => Yii::t('app', 'Telephone'),
			'metaTitle' => Yii::t('app', 'Meta Title'),
			'metaDescription' => Yii::t('app', 'Meta Description'),
			'metaKeyword' => Yii::t('app', 'Meta Keyword'),
			'mailProtocol' => Yii::t('app', 'Mail Protocol'),
			'mailSmtpHost' => Yii::t('app', 'SMTP Hostname'),
			'mailSmtpUser' => Yii::t('app', 'SMTP Username'),
			'mailSmtpPassword' => Yii::t('app', 'SMTP Password'),
			'mailSmtpPort' => Yii::t('app', 'SMTP Port'),
			'uploadLogo' => Yii::t('app', 'Logo'),
			'uploadIcon' => Yii::t('app', 'Icon'),
		];
	}

	public function init() {
		$params = Yii::$app->params;
		foreach ($this->attributes as $name => $value) {
			$this->$name = ArrayHelper::getValue($params, $name);
		}

		$h = Yii::$app->helper;
		$h->initUploadAttribute($this, 'logo', 'uploadLogo');
		$h->initUploadAttribute($this, 'favicon', 'uploadIcon');
	}

	public function save() {
		if ( !$this->validate() ) return false;

		$h = Yii::$app->helper;
		$h->saveUploadFile($this, 'logo', 'uploadLogo');
		$h->saveUploadFile($this, 'favicon', 'uploadIcon');

		$this->saveSettingToFile();
		return true;
	}

	public function saveSettingToFile() {
		$data = $this->attributes;
		unset($data['uploadLogo'], $data['uploadIcon']);
		Yii::$app->helper->saveLocalSetting($data);
	}

	public function getMailProtocolOptions() {
		return [
			'php' => 'php',
			'smtp' => 'smtp',
		];
	}

}
