<?php
?>
<?= $form->field($model, 'payment_code')
	->dropdownList($model->getPaymentMethodOptions(), ['prompt'=>'--- Please Select ---']) ?>
