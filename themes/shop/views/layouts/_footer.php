<?php
use yii\helpers\Url;
?>
<footer>
	<div class="container">
		<div class="row">
			<div class="col-sm-3">
				<h5>Contact</h5>
				<p><i class="fa fa-home"></i> 480/46/17 Nguyễn Tri Phương, P.9, Q.10, TP.HCM</p>
				<p><i class="fa fa-envelope"></i> avansmoke@gmail.com</p>
				<p><i class="fa fa-phone-square"></i> 0933 365 639</p>
			</div>
			<div class="col-sm-3">
				<h5>Information</h5>
				<p><a href="#">About Us</a></p>
				<p><a href="#">Contact Us</a></p>
				<p><a href="#">Delivery Information</a></p>
				<p><a href="#">How to order</a></p>
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
				<p>
					<a href="#">
						<i class="fa fa-facebook-square" aria-hidden="true"></i>
					</a>
				</p>
			</div>
		</div>

		<hr/>

		<p>Powered By <a href="#">lamhq.com</a><br> <?= Yii::$app->name ?> &copy; <?= date('Y') ?></p>
	</div>
</footer>