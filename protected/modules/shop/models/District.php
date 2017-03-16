<?php

namespace shop\models;

use Yii;

/**
 * This is the model class for table "{{%shop_district}}".
 *
 * @property string $id
 * @property string $name
 * @property string $type
 * @property string $location
 * @property string $city_id
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
            [['id', 'name', 'type', 'city_id'], 'required'],
            [['id', 'city_id'], 'string', 'max' => 5],
            [['name'], 'string', 'max' => 100],
            [['sort_order'], 'integer'],
            [['type', 'location'], 'string', 'max' => 30],
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
            'city_id' => Yii::t('shop', 'City ID'),
        ];
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
