<?php

namespace bc\models\form;

use Yii;
use yii\db\ActiveRecord;
use app\behaviors\DateFormatConvertBehavior;

class Car extends \bc\models\Car {
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		$rules = parent::rules();
		return array_merge([
			[['SoXe','SoKhung','SoMay','LoaiTaiSan','TenXe'], 'required',
				'on'=>['insert','update'] ],
		], $rules);
	}
	
	public function behaviors()
	{
		return [
			[
				'class' => DateFormatConvertBehavior::className(),
				'attributes' => ['GDKX_NgayCap', 'GDKX_NgayHH', 'HDTX_DateBegin', 'HDTX_DateEnd', 'NgayBanGiao', 'NgayThanhLy', 'KDX_Ngay'],
				'displayFormat' => 'd/m/Y',
				'storageFormat' => 'Y-m-d',
			],
		];
	}
}