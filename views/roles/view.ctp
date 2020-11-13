<div class="roles view">
	<h2><?php  __('Role');?></h2>
<?php
echo $htmlg->field('Id', $role['Role']['id']);
echo $htmlg->field('Rol', $role['Role']['rol']);
?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $role['Role']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $role['Role']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $role['Role']['id'])); ?> </li>
	</ul>
</div>