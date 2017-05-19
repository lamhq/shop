<?php
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
							$itemsPerCol = 4;
							$colCount = ceil(count($category->categories) / $itemsPerCol);
							?>
							<?php foreach (array_chunk($category->categories, $colCount) as $childrens): ?>
							<ul class="list-unstyled">
								<?php foreach ($childrens as $child): ?>
								<?php
								$child->prependSlug($category->slug);
								?>
								<li><a href="<?= $child->getUrl(); ?>"><?= $child->name ?></a></li>
								<?php endforeach ?>
							</ul>
							<?php endforeach ?>
						</div>
						<a href="<?= $category->getUrl(); ?>" class="see-all"><?= Yii::t('shop', 'Show all') ?> <?= $category->name ?></a> </div>
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