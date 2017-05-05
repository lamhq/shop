<?php

namespace shop\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%shop_order_history}}".
 *
 * @property int $id
 * @property int $order_id
 * @property int $status
 * @property string $comment
 * @property string $created_at
 *
 * @property Order $order
 */
class OrderHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_order_history}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'status'], 'required'],
            [['order_id', 'status'], 'integer'],
            [['comment'], 'string'],
            [['created_at'], 'safe'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop', 'ID'),
            'order_id' => Yii::t('shop', 'Order ID'),
            'status' => Yii::t('shop', 'Status'),
            'comment' => Yii::t('shop', 'Comment'),
            'created_at' => Yii::t('shop', 'Create Time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }
    
    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => function ($event) {
                    return Yii::$app->formatter->asDbDateTime();
                },
                'updatedAtAttribute'=>false,
            ],
        ];
    }

}
