<?php
use yii\helpers\Url;
$h = Yii::$app->helper;
?>
<footer>
	<div class="container">
		<div class="row">
			<div class="col-sm-3">
				<?= $h->block('footer_contact') ?>
			</div>
			<div class="col-sm-3">
				<?= $h->block('footer_links') ?>
			</div>
			<div class="col-sm-3">
				<h5>My Account</h5>
				<p><a href="#">My Account</a></p>
				<p><a href="#">Order History</a></p>
			</div>
			<div class="col-sm-3">
				<p>Sign up for savings, news, updates</p>
				<form id="newsletterForm" action="<?= Url::to(['/shop/default/newsletter']) ?>">
					<div class="input-group">
						<input name="search" value="" placeholder="Search" class="form-control" type="text"/>
						<span class="input-group-btn">
							<button type="submit" class="btn btn-default"><i class="fa fa-arrow-right" aria-hidden="true"></i></button>
						</span>
					</div>
				</form>
				<?= $h->block('footer_social') ?>
			</div>
		</div>

		<hr/>

		<p>Powered By <a href="#">lamhq.com</a><br> <?= Yii::$app->name ?> &copy; <?= date('Y') ?></p>
	</div>
</footer>