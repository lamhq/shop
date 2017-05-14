<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%block}}".
 *
 * @property string $id
 * @property string $title
 * @property string $identifier
 * @property string $content
 * @property int $status 1: active; 2:inactive
 * @property string $created_at
 * @property string $updated_at
 */
class Block extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%block}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'identifier'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'identifier' => Yii::t('app', 'Identifier'),
            'content' => Yii::t('app', 'Content'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \app\models\query\BlockQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\BlockQuery(get_called_class());
    }
}
