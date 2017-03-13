<?php

namespace bc\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%dongxe}}".
 *
 * @property string $TenDongXe
 * @property double $DinhMuc
 * @property string $LoaiXe
 * @property string $QuocGiaSX
 * @property int $NamSX
 *
 * @property Xe[] $xes
 */
class CarBranch extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dongxe}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TenDongXe', 'DinhMuc', 'LoaiXe'], 'required'],
            [['DinhMuc'], 'number'],
            [['NamSX'], 'integer'],
            [['TenDongXe', 'QuocGiaSX'], 'string', 'max' => 100],
            [['LoaiXe'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TenDongXe' => Yii::t('bc', 'Ten Dong Xe'),
            'DinhMuc' => Yii::t('bc', 'Dinh Muc'),
            'LoaiXe' => Yii::t('bc', 'Loai Xe'),
            'QuocGiaSX' => Yii::t('bc', 'Quoc Gia Sx'),
            'NamSX' => Yii::t('bc', 'Nam Sx'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getXes()
    {
        return $this->hasMany(Xe::className(), ['LoaiXe' => 'TenDongXe']);
    }

    static public function getOptions() {
        return ArrayHelper::map(self::find()->all(), 'TenDongXe','TenDongXe');
    }
}
