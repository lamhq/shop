<?php

use yii\helpers\Html; 
use yii\widgets\DetailView; 

/* @var $this yii\web\View */ 
/* @var $model shop\modules\manage\models\Order */ 

$this->title = Yii::t('shop', 'View Order #{0}', $model->id);; 
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('shop', 'Orders'), 
    'url' => ['index']
];
$this->params['breadcrumbs'][] = $this->title; 
?> 
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-shopping-cart"></i> Order Details</h3>
            </div>
        </div>
    </div>
    <div class="col-md-6"></div>
</div>
    <h1><?= Html::encode($this->title) ?></h1> 

    <p> 
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?> 
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [ 
            'class' => 'btn btn-danger', 
            'data' => [ 
                'confirm' => 'Are you sure you want to delete this item?', 
                'method' => 'post', 
            ], 
        ]) ?> 
    </p> 

    <?= DetailView::widget([ 
        'model' => $model, 
        'attributes' => [ 
            'id',
            'invoice_no',
            'customer_id',
            'name',
            'email:email',
            'telephone',
            'payment_method',
            'payment_code',
            'shipping_name',
            'shipping_city_id',
            'shipping_district_id',
            'shipping_ward_id',
            'shipping_address',
            'shipping_method',
            'shipping_code',
            'comment:ntext',
            'total',
            'status',
            'ip',
            'user_agent',
            'accept_language',
            'created_at',
            'updated_at',
        ], 
    ]) ?> 

</div> 