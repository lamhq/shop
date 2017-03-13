<?php

namespace bc\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\models\Car as CarModel;

/**
 * Car represents the model behind the search form of `bc\models\Car`.
 */
class Car extends CarModel
{
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['Serial', 'NamSX'], 'integer'],
			[['SoXe', 'SoKhung', 'SoMay', 'LoaiTaiSan', 'TenXe', 'LoaiXe', 'CSH', 'NganHangVay', 'HinhThucKD', 'NgayBanGiao', 'NgayThanhLy', 'HDTX_DateBegin', 'HDTX_DateEnd', 'GDKX_So', 'GDKX_NgayCap', 'GDKX_NgayHH', 'KDX_Ngay', 'KhoaSoCua', 'GhiChu', 'PathImage'], 'safe'],
			[['NguyenGia'], 'number'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function scenarios()
	{
		// bypass scenarios() implementation in the parent class
		return Model::scenarios();
	}

	/**
	 * Creates data provider instance with search query applied
	 *
	 * @param array $params
	 *
	 * @return ActiveDataProvider
	 */
	public function search($params)
	{
		$query = CarModel::find();

		// add conditions that should always apply here

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort'=>array(
				'defaultOrder'=>[
					'Serial'=>SORT_DESC,
				],
			),            
		]);

		$this->load($params);

		if (!$this->validate()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}

		// grid filtering conditions
		$query->andFilterWhere([
			'Serial' => $this->Serial,
			'NamSX' => $this->NamSX,
			'NgayBanGiao' => $this->NgayBanGiao,
			'NgayThanhLy' => $this->NgayThanhLy,
			'HDTX_DateBegin' => $this->HDTX_DateBegin,
			'HDTX_DateEnd' => $this->HDTX_DateEnd,
			'GDKX_NgayCap' => $this->GDKX_NgayCap,
			'GDKX_NgayHH' => $this->GDKX_NgayHH,
			'KDX_Ngay' => $this->KDX_Ngay,
			'NguyenGia' => $this->NguyenGia,
		]);

		$query->andFilterWhere(['like', 'SoXe', $this->SoXe])
			->andFilterWhere(['like', 'SoKhung', $this->SoKhung])
			->andFilterWhere(['like', 'SoMay', $this->SoMay])
			->andFilterWhere(['like', 'LoaiTaiSan', $this->LoaiTaiSan])
			->andFilterWhere(['like', 'TenXe', $this->TenXe])
			->andFilterWhere(['like', 'LoaiXe', $this->LoaiXe])
			->andFilterWhere(['like', 'CSH', $this->CSH])
			->andFilterWhere(['like', 'NganHangVay', $this->NganHangVay])
			->andFilterWhere(['like', 'HinhThucKD', $this->HinhThucKD])
			->andFilterWhere(['like', 'GDKX_So', $this->GDKX_So])
			->andFilterWhere(['like', 'KhoaSoCua', $this->KhoaSoCua])
			->andFilterWhere(['like', 'GhiChu', $this->GhiChu])
			->andFilterWhere(['like', 'PathImage', $this->PathImage]);

		return $dataProvider;
	}
}
