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
 * @property string $district_id
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
            [['id', 'district_id'], 'string', 'max' => 5],
            [['name'], 'string', 'max' => 100],
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
            'district_id' => Yii::t('shop', 'District ID'),
        ];
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
