<?php

namespace shop\models;

use Yii;

/**
 * This is the model class for table "{{%shop_district}}".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $type
 * @property string $location
 * @property int $sort_order
 * @property int $city_id
 *
 * @property Address[] $shopAddresses
 * @property City $city
 * @property Order[] $shopOrders
 * @property Ward[] $shopWards
 */
class District extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_district}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name', 'type', 'city_id'], 'required'],
            [['sort_order', 'city_id'], 'integer'],
            [['code'], 'string', 'max' => 5],
            [['name'], 'string', 'max' => 100],
            [['type', 'location'], 'string', 'max' => 30],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop', 'ID'),
            'name' => Yii::t('shop', 'Name'),
            'type' => Yii::t('shop', 'Type'),
            'location' => Yii::t('shop', 'Location'),
            'sort_order' => Yii::t('shop', 'Sort Order'),
            'city_id' => Yii::t('shop', 'City ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(Address::className(), ['district_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['shipping_district_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWards()
    {
        return $this->hasMany(Ward::className(), ['district_id' => 'id']);
    }

    static public function getDistrictOptions($cityId) {
        if (!$cityId) return [];
        return self::find()
            ->where(['city_id'=>$cityId])
            ->select(['name','id'])
            ->indexBy('id')
            ->orderBy('sort_order')
            ->column();
    }
}
