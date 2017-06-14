<?= $form->field($model, 'model')->textInput() ?>
<?= $form->field($model, 'price')->textInput() ?>
<?= $form->field($model, 'quantity')->textInput() ?>
<?= $form->field($model, 'status')->dropdownList($model->getStatusOptions()) ?>
