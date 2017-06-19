<?php
namespace shop\modules\manage\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use app\behaviors\DateFormatConvertBehavior;
use shop\models\Order as BaseOrder;

class Order extends BaseOrder
{
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

	static public function getCustomerNames() {
		$names = (new \yii\db\Query())
			->select(['name'])
			->from('{{%shop_order}}')
			->distinct(true)
			->addOrderBy('name')
			->column();
		return $names;
	}
}
