<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%slideshow}}".
 *
 * @property int $id
 * @property string $name
 * @property int $status
 *
 * @property SlideshowImage[] $slideshowImages
 */
class Slideshow extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%slideshow}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSlideshowImages()
    {
        return $this->hasMany(SlideshowImage::className(), ['slideshow_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\query\SlideshowQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\SlideshowQuery(get_called_class());
    }
}
