<?php

namespace shop\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%shop_review}}".
 *
 * @property int $id
 * @property int $product_id
 * @property int $customer_id
 * @property string $author
 * @property string $text
 * @property int $rating
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Product $product
 * @property Customer $customer
 */
class Review extends \yii\db\ActiveRecord
{
    const STATUS_APPROVED = 1;
    const STATUS_PENDING = 0;

    /**
     * used for captcha validation
     * @var string
     */
    public $verificationCode;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_review}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['verificationCode', 'required', 'on'=>'frontend'],
            ['verificationCode', 'captcha', 'captchaAction'=>'/default/captcha', 'on'=>'frontend'],

            [['product_id', 'author', 'text', 'rating'], 'required'],
            [['product_id', 'customer_id', 'rating', 'status'], 'integer'],
            [['text'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['author'], 'string', 'max' => 64],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop', 'ID'),
            'product_id' => Yii::t('shop', 'Product ID'),
            'customer_id' => Yii::t('shop', 'Customer ID'),
            'author' => Yii::t('shop', 'Author'),
            'text' => Yii::t('shop', 'Text'),
            'rating' => Yii::t('shop', 'Rating'),
            'status' => Yii::t('shop', 'Status'),
            'created_at' => Yii::t('shop', 'Create Time'),
            'updated_at' => Yii::t('shop', 'Update Time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    /**
     * @inheritdoc
     * @return \shop\models\query\ReviewQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \shop\models\query\ReviewQuery(get_called_class());
    }

    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => function ($event) {
                    return Yii::$app->formatter->asDbDateTime();
                },
            ],
        ];
    }

    static public function getReviewRange() {
        return range(1, 5);
    }
}
