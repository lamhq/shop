<?php
/* @var $dataProvider \yii\data\ActiveDataProvider */
use yii\widgets\ListView;
?>
<h2><?= Yii::t('shop', "Customer's reviews") ?></h2>
<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_item',
    'summary' => false,
]); ?>