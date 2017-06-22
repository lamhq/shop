<?php
namespace shop\modules\manage\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use app\behaviors\DateFormatConvertBehavior;
use shop\models\Order as BaseOrder;
use shop\models\OrderProduct;
use shop\models\OrderPrice;

class Order extends BaseOrder
{
	public $shippingAddressId;
	
	/**
	 * list of order items
	 * @var array
	 */
	public $items=[];

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
			[['items'], 'required', 'on'=>['insert','update']],
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

	public function afterFind() {
		$this->items = $this->orderProducts;
	}

	public function load($data, $formName = null) {
		if (!parent::load($data, $formName)) return false;

		// after massive assign, we need to
		// convert $this->items from array to models
		$itemsData = is_array($this->items) ? $this->items : [];
		$items = [];
		foreach ($itemsData as $key => $data) {
			$qty = (int)$data['quantity'];
			if (!$qty) continue;

			$productId = $data['product_id'];
			if ( isset($items[$productId]) ) {
				$op = $items[$productId];
				$op->quantity += $qty;
				$op->price = $data['price'];
			} else {
				$op = new OrderProduct($data);
				$items[$productId] = $op;
			}
			$op->total = $op->price*$op->quantity;
		}
		$this->items = $items;
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

	public function getPaymentMethodOptions() {
		$event = Yii::$app->helper->createEvent([
			'sender' => $this,
			'triggerData' => [],
		]);
		Yii::$app->trigger(self::EVENT_COLLECT_PAYMENT_METHOD, $event);
		$methods = $event->triggerData;

		$result = [];
		foreach ($methods as $method) {
			$result[$method['code']] = $method['title'];
		}
		return $result;
	}

	/**
	 * @return float
	 */
	public function getSubTotal() {
		$total = 0;
		foreach ($this->items as $item) {
			$total += $item->total;
		}
		return $total;
	}

	/**
	 * get list of applied prices for cart
	 * @return array
	 */
	public function collectPrices() {
		$event = Yii::$app->helper->createEvent([
			'sender' => $this,
			'triggerData' => [
				'total' => 0,
				'prices' => [],
			],
		]);
		Yii::$app->trigger(self::EVENT_COLLECT_PRICE, $event);

		$data = $event->triggerData;
		$this->total = $data['total'];
		return $data['prices'];
	}

	/**
	 * get order final price
	 * @return double
	 */
	public function calculateTotal() {
		$this->collectPrices();
		return $this->total;
	}

	public function save ( $runValidation = true, $attributeNames = null ) {
		$transaction = Yii::$app->db->beginTransaction();
		try {
			$this->total = $this->calculateTotal();
			if (!parent::save($runValidation, $attributeNames)) {
				return false;
			}

			$this->saveOrderProductRecords();
			$this->saveOrderPrices();
			$this->addOrderHistory($this->status);

			$transaction->commit();
		} catch(\Exception $e) {
			$transaction->rollBack();
			throw $e;
		}
		return true;
	}

	private function saveOrderProductRecords() {
		if (!$this->isNewRecord) {
			$this->unlinkAll('orderProducts',true);
		}
		foreach ($this->items as $item) {
			$item->order_id = $this->id;
			$item->save() || Yii::$app->helper->throwSaveException($item);
		}
	}

	private function saveOrderPrices() {
		if (!$this->isNewRecord) {
			$this->unlinkAll('orderPrices',true);
		}
		foreach ($this->collectPrices() as $item) {
			$orderPrice = new OrderPrice([
				'order_id' => $this->id,
				'code' => $item['code'],
				'title' => $item['title'],
				'value' => $item['value'],
			]);
			$orderPrice->save() || Yii::$app->helper->throwSaveException($orderPrice);
		}
	}
}
