<?php

namespace shop\models;

use Yii;

/**
 * This is the model class for table "{{%shop_city}}".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $type
 * @property int $sort_order
 *
 * @property Address[] $shopAddresses
 * @property District[] $shopDistricts
 * @property Order[] $shopOrders
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_city}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name', 'type'], 'required'],
            [['sort_order'], 'integer'],
            [['code'], 'string', 'max' => 5],
            [['name'], 'string', 'max' => 100],
            [['type'], 'string', 'max' => 30],
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
            'sort_order' => Yii::t('shop', 'Sort Order'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(Address::className(), ['city_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistricts()
    {
        return $this->hasMany(District::className(), ['city_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['shipping_city_id' => 'id']);
    }

    static public function getCityOptions()
    {
        return self::find()
            ->select('name')
            ->indexBy('id')
            ->orderBy('sort_order')
            ->column();
    }
}
