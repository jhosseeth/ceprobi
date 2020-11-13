<div class="magazines form">
<?php echo $form->create('Magazine');?>
	<fieldset>
		<legend>Crear Revista</legend>
<?php
echo $form->input('name', array('label'=>'Nombre de la revista', 'size'=>'40', 'maxlength'=>'45',));
echo $form->input('description', array('label'=>'Descripción', 'placeholder'=>'Escriba acerca de la revista...', 'cols'=>'60', 'rows'=>'6'));
?>
	</fieldset>
<?php echo $form->end(array('class'=>'btn btn-primary space', 'label'=>'Guardar'));?>
</div>