<?php

namespace shop\models;

use Yii;

/**
 * This is the model class for table "{{%shop_category_relation}}".
 *
 * @property int $id
 * @property int $ancestor_id
 * @property int $descendant_id
 * @property int $level
 *
 * @property ShopCategory $ancestor
 * @property ShopCategory $descendant
 */
class CategoryRelation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_category_relation}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ancestor_id', 'descendant_id'], 'required'],
            [['ancestor_id', 'descendant_id', 'level'], 'integer'],
            [['ancestor_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopCategory::className(), 'targetAttribute' => ['ancestor_id' => 'id']],
            [['descendant_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopCategory::className(), 'targetAttribute' => ['descendant_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop', 'ID'),
            'ancestor_id' => Yii::t('shop', 'Ancestor ID'),
            'descendant_id' => Yii::t('shop', 'Descendant ID'),
            'level' => Yii::t('shop', 'Level'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAncestor()
    {
        return $this->hasOne(ShopCategory::className(), ['id' => 'ancestor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDescendant()
    {
        return $this->hasOne(ShopCategory::className(), ['id' => 'descendant_id']);
    }
}
