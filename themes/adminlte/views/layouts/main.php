<?php
/**
 * @var $this yii\web\View
 */
use yii\widgets\Breadcrumbs;
use app\widgets\Alert;
$this->params['body-class'] = 'sidebar-mini';
?>
<?php $this->beginContent('@webroot/themes/adminlte/views/layouts/base.php'); ?>
<div class="wrapper">
	<?= $this->render('_header') ?>
	
	<?php echo $this->render('_sidebar') ?>
		
	<!-- Right side column. Contains the navbar and content of the page -->
	<aside class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				<?= $this->title ?>
				<?php if(isset($this->params['subtitle'])): ?>
					<small><?= $this->params['subtitle'] ?></small>
				<?php endif; ?>
			</h1>

			<?= Breadcrumbs::widget([
				'homeLink'=>[
					'label'=>Yii::t('backend', 'Home'),
					'url'=>['/backend']
				],
				'tag'=>'ol',
				'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
			]) ?>
		</section>

		<!-- Main content -->
		<section class="content">
			<p class="text-right"><?= $this->blocks['buttons']  ?></p>
		
			<?= Alert::widget() ?>

			<?php echo $content ?>
		</section><!-- /.content -->

	</aside><!-- /.right-side -->
</div>
<?php $this->endContent(); ?>