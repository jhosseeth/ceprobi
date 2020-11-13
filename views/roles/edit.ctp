<div class="roles form">
<?php echo $form->create('Role');?>
	<fieldset>
		<legend><?php printf("%s %s", __('Edit', true), __('Role', true)); ?></legend>
<?php
echo $form->input('id', array('label'=>__('Id', true), 'size'=>'11', 'maxlength'=>'11',));
echo $form->input('name', array('label'=>__('Rol', true), 'size'=>'40', 'maxlength'=>'45',));
?>
	</fieldset>
<?php echo $form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Role.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Role.id'))); ?></li>
		<li><?php echo $html->link(__('List Roles', true), array('action' => 'index'));?></li>
	</ul>
</div>