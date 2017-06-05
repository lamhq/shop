<?php

namespace shop\models;

use Yii;

/**
 * This is the model class for table "{{%shop_address}}".
 *
 * @property int $id
 * @property string $name
 * @property string $city_id
 * @property string $district_id
 * @property string $ward_id
 * @property string $address
 * @property int $customer_id
 *
 * @property Customer $customer
 * @property City $city
 * @property District $district
 * @property Ward $ward
 * @property Customer[] $shopCustomers
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
            [['name','city_id','address'], 'required', 'on'=>['guestCheckout','accountCheckout']],
            [['name','city_id','address','customer_id'], 'required', 'on'=>['insert','update']],
            
            [['customer_id'], 'integer'],
            [['name'], 'string', 'max' => 64],
            [['city_id', 'district_id', 'ward_id'], 'string', 'max' => 5],
            [['address'], 'string', 'max' => 128],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => District::className(), 'targetAttribute' => ['district_id' => 'id']],
            [['ward_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ward::className(), 'targetAttribute' => ['ward_id' => 'id']],
            [['city_id', 'district_id', 'ward_id'], 'default', 'value' => null],
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
            'city_id' => Yii::t('shop', 'City'),
            'district_id' => Yii::t('shop', 'District'),
            'ward_id' => Yii::t('shop', 'Ward'),
            'address' => Yii::t('shop', 'Address'),
            'customer_id' => Yii::t('shop', 'Customer ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistrict()
    {
        return $this->hasOne(District::className(), ['id' => 'district_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWard()
    {
        return $this->hasOne(Ward::className(), ['id' => 'ward_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomers()
    {
        return $this->hasMany(Customer::className(), ['address_id' => 'id']);
    }

    public function getText() {
        $city = $this->city ? $this->city->name : '';
        $district = $this->district ? Yii::t('shop', 'District {0}', $this->district->name) : '';
        $ward = $this->ward ? Yii::t('shop', 'Ward {0}', $this->ward->name) : '';
        $arr = array_filter([$this->name, $city, $district, $ward, $this->address]);
        return implode(', ', $arr);
    }
}
