<div class="form">
<?php echo $form->create('Message');?>
	<fieldset>
		<legend>Editar Mensaje</legend>
<?php
echo $form->input('id', array('label'=>'Id', 'size'=>'11', 'maxlength'=>'11',));
echo $form->input('name', array('label'=>'Nombre'));
echo $form->input('dir', array('label'=>'Dirección'));
echo $form->input('description', array('label'=>'Descripción', 'cols'=>'60', 'rows'=>'6'));
?>
	</fieldset>
<?php echo $form->end(array('class'=>'btn btn-primary btn-form', 'label'=>'Guardar'));?>
</div>