<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel bc\models\search\Car */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('bc', 'Car');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginBlock('buttons') ?>
	<a href="<?= Url::to(['create']) ?>" class="btn btn-primary" title="<?= Yii::t('backend', 'Add New') ?>"><i class="fa fa-plus"></i></a>
<?php $this->endBlock() ?>

<div class="car-index">

	<?php Pjax::begin(); ?>
		<?= $this->render('_search', ['model' => $searchModel]); ?>
		
		<?= GridView::widget([
			'dataProvider' => $dataProvider,
			'columns' => [
				['class' => 'yii\grid\SerialColumn'],
		
				'SoXe',
				'SoKhung',
				'SoMay',
				'LoaiTaiSan',
				'TenXe',
				// 'Serial',
				// 'LoaiXe',
				// 'NamSX',
				// 'CSH',
				// 'NganHangVay',
				// 'HinhThucKD',
				// 'NgayBanGiao',
				// 'NgayThanhLy',
				// 'HDTX_DateBegin',
				// 'HDTX_DateEnd',
				// 'GDKX_So',
				// 'GDKX_NgayCap',
				// 'GDKX_NgayHH',
				// 'KDX_Ngay',
				// 'NguyenGia',
				// 'KhoaSoCua',
				// 'GhiChu',
				// 'PathImage',
	
				[
					'class' => 'yii\grid\ActionColumn',
					'template' => '{update} {delete}',
				],
			],
		]); ?>
	<?php Pjax::end(); ?>
</div>
