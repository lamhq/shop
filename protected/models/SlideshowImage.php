<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%slideshow_image}}".
 *
 * @property int $id
 * @property string $title
 * @property string $link
 * @property string $image
 * @property int $slideshow_id
 *
 * @property Slideshow $slideshow
 */
class SlideshowImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%slideshow_image}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slideshow_id'], 'integer'],
            [['title'], 'string', 'max' => 64],
            [['link', 'image'], 'string', 'max' => 255],
            [['slideshow_id'], 'exist', 'skipOnError' => true, 'targetClass' => Slideshow::className(), 'targetAttribute' => ['slideshow_id' => 'id']],
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
            'link' => Yii::t('app', 'Link'),
            'image' => Yii::t('app', 'Image'),
            'slideshow_id' => Yii::t('app', 'Slideshow ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSlideshow()
    {
        return $this->hasOne(Slideshow::className(), ['id' => 'slideshow_id']);
    }

    public function getImageUrl() {
        return Yii::$app->helper->getStorageUrl($this->image);
    }

}
