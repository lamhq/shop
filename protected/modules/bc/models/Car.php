<?php

namespace bc\models;

use Yii;

/**
 * This is the model class for table "{{%xe}}".
 *
 * @property int $Serial
 * @property string $SoXe
 * @property string $SoKhung
 * @property string $SoMay
 * @property string $LoaiTaiSan
 * @property string $TenXe
 * @property string $LoaiXe
 * @property int $NamSX
 * @property string $CSH
 * @property string $NganHangVay
 * @property string $HinhThucKD
 * @property string $NgayBanGiao
 * @property string $NgayThanhLy
 * @property string $HDTX_DateBegin
 * @property string $HDTX_DateEnd
 * @property string $GDKX_So
 * @property string $GDKX_NgayCap
 * @property string $GDKX_NgayHH
 * @property string $KDX_Ngay
 * @property string $NguyenGia
 * @property string $KhoaSoCua
 * @property string $GhiChu
 * @property string $PathImage
 *
 * @property Baohiemxe[] $baohiemxes
 * @property Nhatkyxe[] $nhatkyxes
 * @property Dongxe $loaiXe
 */
class Car extends \yii\db\ActiveRecord
{
	const TAI_SAN_CONG_TY = 'Tài sản công ty';
	const TAI_SAN_THUE_NGOAI = 'Tài sản thuê ngoài';

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%xe}}';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['SoXe'], 'required'],
			[['NamSX'], 'integer'],
			[['NgayBanGiao', 'NgayThanhLy', 'HDTX_DateBegin', 'HDTX_DateEnd', 'GDKX_NgayCap', 'GDKX_NgayHH', 'KDX_Ngay'], 'safe'],
			[['NguyenGia'], 'number'],
			[['SoXe'], 'string', 'max' => 20],
			[['SoKhung', 'SoMay', 'LoaiTaiSan', 'TenXe', 'HinhThucKD', 'GDKX_So', 'KhoaSoCua'], 'string', 'max' => 50],
			[['LoaiXe', 'CSH', 'NganHangVay'], 'string', 'max' => 100],
			[['GhiChu', 'PathImage'], 'string', 'max' => 150],
			[['SoXe'], 'unique'],
			[['LoaiXe'], 'exist', 'skipOnError' => true, 'targetClass' => CarBranch::className(), 'targetAttribute' => ['LoaiXe' => 'TenDongXe']],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'Serial' => Yii::t('bc', 'Serial'),
			'SoXe' => Yii::t('bc', 'SoXe'),
			'SoKhung' => Yii::t('bc', 'SoKhung'),
			'SoMay' => Yii::t('bc', 'SoMay'),
			'LoaiTaiSan' => Yii::t('bc', 'LoaiTaiSan'),
			'TenXe' => Yii::t('bc', 'TenXe'),
			'LoaiXe' => Yii::t('bc', 'LoaiXe'),
			'NamSX' => Yii::t('bc', 'NamSX'),
			'CSH' => Yii::t('bc', 'CSH'),
			'NganHangVay' => Yii::t('bc', 'NganHangVay'),
			'HinhThucKD' => Yii::t('bc', 'HinhThucKD'),
			'NgayBanGiao' => Yii::t('bc', 'NgayBanGiao'),
			'NgayThanhLy' => Yii::t('bc', 'NgayThanhLy'),
			'HDTX_DateBegin' => Yii::t('bc', 'HDTX_DateBegin'),
			'HDTX_DateEnd' => Yii::t('bc', 'HDTX_DateEnd'),
			'GDKX_So' => Yii::t('bc', 'GDKX_So'),
			'GDKX_NgayCap' => Yii::t('bc', 'GDKX_NgayCap'),
			'GDKX_NgayHH' => Yii::t('bc', 'GDKX_NgayHH'),
			'KDX_Ngay' => Yii::t('bc', 'KDX_Ngay'),
			'NguyenGia' => Yii::t('bc', 'NguyenGia'),
			'KhoaSoCua' => Yii::t('bc', 'KhoaSoCua'),
			'GhiChu' => Yii::t('bc', 'GhiChu'),
			'PathImage' => Yii::t('bc', 'Path Image'),
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getBaohiemxes()
	{
		return $this->hasMany(Baohiemxe::className(), ['Serial_Xe' => 'Serial']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getNhatkyxes()
	{
		return $this->hasMany(Nhatkyxe::className(), ['Serial_Xe' => 'Serial']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getLoaiXe()
	{
		return $this->hasOne(Dongxe::className(), ['TenDongXe' => 'LoaiXe']);
	}

	/**
	 * @inheritdoc
	 * @return \bc\models\query\CarQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new \bc\models\query\CarQuery(get_called_class());
	}

	static public function getLoaiTaiSanOptions() {
		return [
			self::TAI_SAN_CONG_TY => Yii::t('bc', 'Tài sản công ty'),
			self::TAI_SAN_THUE_NGOAI => Yii::t('bc', 'Tài sản thuê ngoài'),
		];
	}

	static public function getNganHangOptions() {
		return [
			'ACB - Ngân hàng Á Châu' => 'ACB - Ngân hàng Á Châu',
			'DAF - Ngân hàng Đông Á' => 'DAF - Ngân hàng Đông Á',
		];
	}
}
