<?php
namespace shop\modules\manage\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use app\behaviors\DateFormatConvertBehavior;
use shop\models\Order as BaseOrder;

class Order extends BaseOrder
{
	public $shippingAddressId;
	
	/**
	 * list of order items
	 * @var array
	 */
	public $cartItems=[];

	public function behaviors() {
		$h = Yii::$app->helper;
		return array_merge(parent::behaviors(), [
			[
				'class' => DateFormatConvertBehavior::className(),
				'attributes'=> ['created_at','updated_at'],
				'displayFormat'=>$h->getDateFormat('php2'),
				'storageFormat'=>$h->getDateFormat('db2'),
			],
		]);
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return array_merge(parent::rules(), [
			[['cartItems'], 'required', 'on'=>['insert','update']],
			[['id', 'name', 'status', 'total', 'created_at', 'updated_at'], 'safe', 'on'=>'search'],
		]);
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(), [
		]);
	}

	public function load($data, $formName = null) {
		if (!parent::load($data, $formName)) return false;
		// reset data for property that accept array
		if (!is_array($this->cartItems)) {
			$this->cartItems = [];
		}

		// update item quantity
		$items = [];
		foreach ($this->cartItems as $key => $item) {
			$productId = $item['product_id'];
			if ( isset($items[$productId]) ) {
				$it = &$items[$productId];
				$it['quantity'] += $item['quantity'];
				$it['price'] = $item['price'];
			} else {
				$items[$productId] = $item;
			}
		}
		$this->cartItems = $items;

		foreach ($this->cartItems as $key => &$item) {
			// remove item with quantity = 0
			if ($item['quantity']==0)
				unset($this->cartItems[$key]);
			// update total
			$item['total'] = $item['price']*$item['quantity'];
		}

		return true;
	}

	/**
	 * Creates data provider instance with search query applied
	 * @return ActiveDataProvider
	 */
	public function search($params)
	{
		$query = BaseOrder::find();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$h = Yii::$app->helper;
		$createdAt = $h->convertDateTime($this->created_at, $h->getDateFormat('php2'), $h->getDateFormat('db2'));
		$updatedAt = $h->convertDateTime($this->updated_at, $h->getDateFormat('php2'), $h->getDateFormat('db2'));
		$query->andFilterWhere(['like', 'name', $this->name]);
		$query->andFilterWhere(['like', 'created_at', $createdAt]);
		$query->andFilterWhere(['like', 'updated_at', $updatedAt]);
		$query->andFilterWhere([
			'id'=>$this->id,
			'total'=>$this->total,
			'status'=>$this->status,
		]);
		return $dataProvider;
	}

	public function afterFind() {
		foreach ($this->orderProducts as $item) {
			$this->cartItems[] = $item->attributes;
		}
	}

	/**
	 * get list of payment method
	 * @return array [ [code, title] ]
	 */
	public function getAvailablePaymentMethods() {
		$event = Yii::$app->helper->createEvent([
			'sender' => $this,
			'triggerData' => [],
		]);
		Yii::$app->trigger(self::EVENT_COLLECT_PAYMENT_METHOD, $event);

		return $event->triggerData;
	}

	public function getPaymentMethodOptions() {
		$result = [];
		foreach ($this->getAvailablePaymentMethods() as $method) {
			$result[$method['code']] = $method['title'];
		}
		return $result;
	}

}
