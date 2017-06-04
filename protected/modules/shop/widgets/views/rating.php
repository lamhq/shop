<?php
?>
<?php for ($i = $min; $i <= $max; $i++): ?>
	<?php if ($value < $i): ?>
	<span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
	<?php else: ?>
	<span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
	<?php endif ?>
<?php endfor ?>
