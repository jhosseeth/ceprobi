<div class="roles index">
	<?php 
	if ($_SESSION['Auth']['Role']['name'] == 'Administrador') {
		echo $this->Html->link('Crear Rol', array('action' => 'add'), array('class'=>'pull-right btn break-line'));
	}
	?>
	<h2>Roles</h2>
	<div class="row-fluid">
		<div class="span6">
			<table cellpadding="0" cellspacing="0" class="table">
				<tr>
					<th>#</th>
					<th>Rol</th>
					<?php if ($_SESSION['Auth']['Role']['name'] == 'Administrador'): ?>
					<th class="actions">Acciones</th>
					<?php endif; ?>
				</tr>
				<?php
				$i = 0;
				foreach ($roles as $rol):
					$class = null;
					if ($i++ % 2 == 0) $class = ' class="altrow"';
				?>
				<tr<?php echo $class;?> id="<?php echo $rol['Role']['id']; ?>">
					<td><?php echo $i; ?>&nbsp;</td>
					<td><?php echo $rol['Role']['name']; ?>&nbsp;</td>
					<?php if ($_SESSION['Auth']['Role']['name'] == 'Administrador'): ?>
					<td class="actions">
						<?php echo $this->Html->link('Ver', array('action' => 'view', $rol['Role']['id'])); ?>
						<?php echo $this->Html->link('Editar', array('action' => 'edit', $rol['Role']['id'])); ?> 
						<?php echo $this->Html->link('Eliminar', array('action' => 'delete', $rol['Role']['id']), null, '¿Esta seguro que quiere eliminar el rol?'); ?>						
					</td>
					<?php endif; ?>
				</tr>
			<?php endforeach; ?>
			</table>
		</div>
		<div class="span6"></div>
	</div>
	

	
</div>