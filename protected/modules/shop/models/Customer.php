<?php

namespace shop\models;

use Yii;
use yii\web\IdentityInterface;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%shop_customer}}".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $telephone
 * @property string $password_hash
 * @property int $status
 * @property int $newsletter
 * @property int $address_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Address[] $addresses
 * @property Address $defaultAddress
 */
class Customer extends \yii\db\ActiveRecord implements IdentityInterface
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_customer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'newsletter', 'address_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 64],
            [['email'], 'string', 'max' => 96],
            [['telephone'], 'string', 'max' => 32],
            [['password_hash'], 'string', 'max' => 255],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => Address::className(), 'targetAttribute' => ['address_id' => 'id']],
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
            'email' => Yii::t('shop', 'Email'),
            'telephone' => Yii::t('shop', 'Telephone'),
            'password_hash' => Yii::t('shop', 'Password Hash'),
            'status' => Yii::t('shop', 'Status'),
            'newsletter' => Yii::t('shop', 'Newsletter'),
            'address_id' => Yii::t('shop', 'Address ID'),
            'created_at' => Yii::t('shop', 'Create Time'),
            'updated_at' => Yii::t('shop', 'Update Time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(Address::className(), ['customer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDefaultAddress()
    {
        return $this->hasOne(Address::className(), ['id' => 'address_id']);
    }

    /**
     * @inheritdoc
     * @return \shop\models\query\CustomerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \shop\models\query\CustomerQuery(get_called_class());
    }

    /**
     * @param Address $address
     */
    public function addAddress($address) {
        $address->customer_id = $this->id;
        $result = $address->save() || Yii::$app->helper->throwSaveException($address);
        $this->address_id = $address->id;
        $r = $this->update(['address_id']);
        return $result;
    }

    /**
     * [addAddress description]
     * @param Address $address [description]
     */
    public function getAddressOptions() {
    	$result = [];
        foreach ($this->addresses as $address) {
        	$result[$address->id] = $address->getText();
        }
        return $result;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::find()
            ->where('(email=:s OR telephone=:s) AND status=:status', [
                ':s'=>$username,
                ':status'=>self::STATUS_ACTIVE,
            ])
            ->one();
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
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
    
}
