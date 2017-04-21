<?php

namespace shop\models;

use Yii;

/**
 * This is the model class for table "{{%shop_ward}}".
 *
 * @property string $id
 * @property string $name
 * @property string $type
 * @property string $location
 * @property int $sort_order
 * @property string $district_id
 *
 * @property Address[] $shopAddresses
 * @property Order[] $shopOrders
 * @property District $district
 */
class Ward extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_ward}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'type', 'district_id'], 'required'],
            [['sort_order'], 'integer'],
            [['id', 'district_id'], 'string', 'max' => 5],
            [['name'], 'string', 'max' => 100],
            [['type', 'location'], 'string', 'max' => 30],
            [['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => District::className(), 'targetAttribute' => ['district_id' => 'id']],
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
            'district_id' => Yii::t('shop', 'District ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(Address::className(), ['ward_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['shipping_ward_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistrict()
    {
        return $this->hasOne(District::className(), ['id' => 'district_id']);
    }

    static public function getWardOptions($districtId) {
        if (!$districtId) return [];
        return self::find()
            ->where(['district_id'=>$districtId])
            ->select('name')
            ->indexBy('id')
            ->orderBy('sort_order')
            ->column();
    }
}
