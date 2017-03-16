<?php

namespace shop\models;

use Yii;

/**
 * This is the model class for table "{{%shop_city}}".
 *
 * @property string $id
 * @property string $name
 * @property string $type
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
            [['id', 'name', 'type'], 'required'],
            [['id'], 'string', 'max' => 5],
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
        ];
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
