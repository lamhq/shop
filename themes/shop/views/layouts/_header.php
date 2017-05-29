<?php
use yii\helpers\Url;
?>
<nav id="top">
	<div class="container">
		<div id="top-links" class="nav pull-right">
			<ul class="list-inline">
				<li>
					<a href="<?= Yii::$app->helper->getPageUrl('about-us') ?>" title="<?= Yii::t('app', 'Contact') ?>"><i class="fa fa-phone"></i></a>
					<span class="hidden-xs"><?= Yii::$app->params['phone'] ?></span>
				</li>
				<li class="dropdown">
					<a href="<?= Url::to(['/shop/account/profile']) ?>" title="<?= Yii::t('app', 'My Account') ?>" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						<i class="fa fa-user"></i>
						<span class="hidden-xs"><?= Yii::t('app', 'My Account') ?></span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu dropdown-menu-right">
						<?php if (Yii::$app->user->isGuest): ?>
						<li><a href="<?= Url::to(['/shop/default/register']) ?>"><?= Yii::t('app', 'Register') ?></a></li>
						<li><a href="<?= Url::to(['/shop/default/login']) ?>"><?= Yii::t('app', 'Login') ?></a></li>
						<?php else: ?>
						<li><a href="<?= Url::to(['/shop/account/update']) ?>"><?= Yii::t('app', 'My Account') ?></a></li>
						<li><a href="<?= Url::to(['/shop/account/order']) ?>"><?= Yii::t('app', 'Order History') ?></a></li>
						<li><a href="<?= Url::to(['/shop/default/logout']) ?>"><?= Yii::t('app', 'Logout') ?></a></li>
						<?php endif ?>
					</ul>
				</li>
				<li>
					<a href="<?= Url::to(['/shop/cart']) ?>" title="<?= Yii::t('shop', 'Checkout') ?>">
						<i class="fa fa-shopping-cart"></i>
						<span class="hidden-xs"><?= Yii::t('shop', 'Checkout') ?></span>
					</a>
				</li>
			</ul>
		</div>
	</div>
</nav>

<header>
	<div class="container">
		<div class="row">
			<div class="col-sm-4">
				<div id="logo">
					<a href="<?= Yii::$app->homeUrl ?>"><img src="<?= Yii::$app->helper->getLogoUrl() ?>" title="<?= Yii::$app->name ?>" alt="<?= Yii::$app->name ?>" class="img-responsive"></a>
				</div>
			</div>
			<div class="col-sm-5">
				<?= \shop\widgets\SearchForm::widget() ?>
			</div>
			<div class="col-sm-3">
				<div id="cart">
					<?= \shop\widgets\CartDropdown::widget() ?>
				</div>
			</div>
		</div>
	</div>
</header>

<?= shop\widgets\CategoryMenu::widget(); ?>
