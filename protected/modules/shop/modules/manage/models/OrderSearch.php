<?php
namespace shop\modules\manage\models;

use Yii;
use yii\data\ActiveDataProvider;
use app\behaviors\DateFormatConvertBehavior;
use shop\models\Order as BaseOrder;

class OrderSearch extends BaseOrder
{
	public function behaviors() {
		$h = Yii::$app->helper;
		return [
			[
				'class' => DateFormatConvertBehavior::className(),
				'attributes'=> ['created_at','updated_at'],
				'displayFormat'=>$h->getDateFormat('php2'),
				'storageFormat'=>$h->getDateFormat('db2'),
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id', 'name', 'status', 'total', 'created_at', 'updated_at'], 'safe', 'on'=>'search'],
		];
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
}