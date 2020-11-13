<div class="roles form">
<?php echo $form->create('Role');?>
	<fieldset>
		<legend><?php printf("%s %s", __('Add', true), __('Role', true)); ?></legend>
<?php
echo $form->input('name', array('label'=>'Rol', 'size'=>'40', 'maxlength'=>'45',));
?>
	</fieldset>
<?php echo $form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $html->link(__('List Roles', true), array('action' => 'index'));?></li>
	</ul>
</div>