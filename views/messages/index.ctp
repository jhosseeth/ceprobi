<?php echo $this->Html->script('bootstrap/bootstrap-alert'); ?>
<?php echo $this->Session->flash(); ?>
<div class="index">
	<legend><h2>Mensajes</h2></legend>
	<div class="row-fluid space">

<?php foreach ($messages as $ms): ?>

		<div id="<?php echo $ms['Message']['id']; ?>" class="messages">
			<div class="ms-header">
				<h3 class="ms-title"><?php echo $ms['Message']['name'];?></h3>
				<?php 
				if ($_SESSION['Auth']['Role']['name'] == 'Administrador') echo $this->Html->link( $html->image('pencil.png',array('class'=>'ms-actions')), array('action' => 'edit', $ms['Message']['id']), array('class'=>'pull-right', 'title'=>'Editar Mensaje', 'escape'=>false));
				?>
			</div>
			<div class="ms-content">
				<p><strong>Ruta:</strong> <?php echo $ms['Message']['dir']; ?></p>
				<p><?php echo $ms['Message']['description']; ?></p>			
			</div>
		</div>
				
<?php endforeach; ?>
	
	</div>
</div>