<?php
/**
 * @var $this yii\web\View
 */
use backend\widgets\AdminLteMenu;
use backend\widgets\AuthBlock;
?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<?= AdminLteMenu::widget([
			'items'=>[
				['label'=>Yii::t('backend', 'Content'), 'icon'=>'fa fa-tags fa-fw', 'items'=>[
					[
						'label'=>Yii::t('bc', 'Xe'), 
						'url'=>['/bc/admin/car/index']
					],
				]],
			]
		]) ?>
	</section>
	<!-- /.sidebar -->
</aside>
