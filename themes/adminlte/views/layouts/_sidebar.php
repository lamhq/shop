<?php
/**
 * @var $this yii\web\View
 */
use backend\widgets\AdminLteMenu;
?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<?= AdminLteMenu::widget([
			'items'=>[
				['label'=>Yii::t('shop', 'Catalog'), 'icon'=>'fa fa-tags fa-fw', 'items'=>[
					[
						'label'=>Yii::t('shop', 'Product'), 
						'url'=>['/shop/manage/product/index']
					],
					[
						'label'=>Yii::t('shop', 'Category'), 
						'url'=>['/shop/manage/category/create']
					],
					[
						'label'=>Yii::t('app', 'Slideshow'), 
						'url'=>['/backend/slideshow/index']
					],
				]],
				['label'=>Yii::t('shop', 'Sales'), 'icon'=>'fa fa-shopping-cart fw', 'items'=>[
					[
						'label'=>Yii::t('shop', 'Order'), 
						'url'=>['/shop/manage/order/index']
					],
				]],
				['label'=>Yii::t('shop', 'System'), 'icon'=>'fa fa-cog fw', 'items'=>[
					[
						'label'=>Yii::t('shop', 'Setting'), 
						'url'=>['/backend/setting/index']
					],
				]],
			]
		]) ?>
	</section>
	<!-- /.sidebar -->
</aside>
