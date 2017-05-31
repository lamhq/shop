<?php
use yii\helpers\StringHelper;
$this->registerJs('app.setupMainMenu();');
?>
<?php if ($categories): ?>
<div class="container">
	<nav id="menu" class="navbar">
		<div class="navbar-header"><span id="category" class="visible-xs"><?= Yii::t('shop', 'Categories') ?></span>
			<button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse" data-target=".menu-collapse"><i class="fa fa-bars"></i></button>
		</div>
		<div class="collapse navbar-collapse menu-collapse">
			<ul class="nav navbar-nav">
				<?php foreach ($categories as $category): ?>
				<?php if ($category->categories): ?>
				<li class="dropdown"><a href="<?= $category->getUrl(); ?>" class="dropdown-toggle" data-toggle="dropdown"><?= $category->name ?></a>
					<div class="dropdown-menu">
						<div class="dropdown-inner">
							<?php
							$noipc = 4; // number of items per columns
							$noc = ceil(count($category->categories)/$noipc); // number of column
							if ( $noc > 4) {
								$noipc = ceil(count($category->categories)/4);
							}
							?>
							<?php foreach (array_chunk($category->categories, $noipc) as $ipc): ?>
							<ul class="list-unstyled">
								<?php foreach ($ipc as $child): ?>
								<?php
								$child->prependSlug($category->slug);
								?>
								<li><a href="<?= $child->getUrl(); ?>"><?= StringHelper::truncate($child->name,17) ?></a></li>
								<?php endforeach ?>
							</ul>
							<?php endforeach ?>
						</div>
						<a href="<?= $category->getUrl(); ?>" class="see-all"><?= Yii::t('shop', 'Show all {0}', $category->name) ?></a> </div>
				</li>
				<?php else: ?>
				<li><a href="<?= $category->getUrl(); ?>"><?= $category->name ?></a></li>
				<?php endif ?>
				<?php endforeach ?>
			</ul>
		</div>
	</nav>
</div>
<?php endif ?>