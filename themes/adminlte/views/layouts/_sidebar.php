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
				]],
			]
		]) ?>
	</section>
	<!-- /.sidebar -->
</aside>
