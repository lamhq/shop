<?php

namespace shop\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class AddToCartForm extends Model
{
	public $productId;
	public $qty;

	private $_product = false;


	/**
	 * @return array the validation rules.
	 */
	public function rules()
	{
		return [
			[['productId', 'qty'], 'required'],
			[['qty'], 'integer', 'min'=>1, 'integerOnly'=>true],
			[['productId'], 'exist', 'targetClass'=>'\shop\models\Product', 
				'targetAttribute'=>'id'],
		];
	}

    public function formName()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'qty' => Yii::t('shop', 'Qty'),
        ];
    }

	/**
	 * @return Product|null
	 */
	public function getProduct()
	{
		if ($this->_product === false) {
			$this->_product = Product::findOne($this->productId);
		}

		return $this->_product;
	}

	public function resetFormData() {
		$this->qty = 1;
	}
}
