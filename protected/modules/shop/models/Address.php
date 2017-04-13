<?php

namespace shop\models;

use Yii;

/**
 * This is the model class for table "{{%shop_address}}".
 *
 * @property int $id
 * @property string $name
 * @property string $city
 * @property string $district
 * @property string $ward
 * @property string $address
 * @property int $customer_id
 *
 * @property ShopCustomer $customer
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_address}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'city', 'district', 'ward', 'address'], 'required'],

            [['customer_id'], 'integer'],
            [['city', 'district', 'ward', 'address'], 'string', 'max' => 128],
            [['name'], 'string', 'max' => 64],
            // [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop', 'ID'),
            'city' => Yii::t('shop', 'City'),
            'district' => Yii::t('shop', 'District'),
            'ward' => Yii::t('shop', 'Ward'),
            'address' => Yii::t('shop', 'Address'),
            'customer_id' => Yii::t('shop', 'Customer ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(ShopCustomer::className(), ['id' => 'customer_id']);
    }

    public function getText() {
        $city = $this->cityModel ? $this->cityModel->name : '';
        $district = $this->districtModel ? $this->districtModel->name : '';
        $ward = $this->wardModel ? $this->wardModel->name : '';
        $arr = array_filter([$this->name, $city, $district, $ward]);
        return implode(', ', $arr);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCityModel()
    {
        return $this->hasOne(City::className(), ['id' => 'city']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistrictModel()
    {
        return $this->hasOne(District::className(), ['id' => 'district']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWardModel()
    {
        return $this->hasOne(Ward::className(), ['id' => 'ward']);
    }

}
