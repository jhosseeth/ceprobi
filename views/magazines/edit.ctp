<div class="magazines form">
<?php echo $form->create('Magazine');?>
	<fieldset>
		<legend>Editar Revista</legend>
<?php
echo $form->input('id', array('label'=>'Id', 'size'=>'11', 'maxlength'=>'11',));
echo $form->input('name', array('label'=>'Nombre de la revista', 'size'=>'40', 'maxlength'=>'45',));
echo $form->input('description', array('label'=>'Descripcion', 'placeholder'=>'Escriba acerca de la revista...', 'cols'=>'60', 'rows'=>'6'));
?>
	</fieldset>
<?php echo $html->link('Eliminar', array('action' => 'delete', $this->Form->value('Magazine.id')), array('class'=>'btn btn-form'), sprintf(__('¿Esta seguro que quiere eliminar %s?', true), $this->Form->value('Magazine.name'))); ?>
<?php echo $form->end(array('class'=>'btn btn-primary btn-form', 'label'=>'Guardar'));?>
</div>