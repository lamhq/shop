<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model bc\models\Car */

$this->title = $model->Serial;
$this->params['breadcrumbs'][] = ['label' => Yii::t('bc', 'Cars'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="car-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('bc', 'Update'), ['update', 'id' => $model->Serial], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('bc', 'Delete'), ['delete', 'id' => $model->Serial], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('bc', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'Serial',
            'SoXe',
            'SoKhung',
            'SoMay',
            'LoaiTaiSan',
            'TenXe',
            'LoaiXe',
            'NamSX',
            'CSH',
            'NganHangVay',
            'HinhThucKD',
            'NgayBanGiao',
            'NgayThanhLy',
            'HDTX_DateBegin',
            'HDTX_DateEnd',
            'GDKX_So',
            'GDKX_NgayCap',
            'GDKX_NgayHH',
            'KDX_Ngay',
            'NguyenGia',
            'KhoaSoCua',
            'GhiChu',
            'PathImage',
        ],
    ]) ?>

</div>
