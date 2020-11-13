<?php if ($_SESSION['Auth']['Role']['name'] == 'Administrador') {
	$class = 'magazines index row-fluid';
	echo $this->Html->link('Crear Revista', array('action' => 'add'), array('class'=>'btn btn-info pull-right'));
	echo "<h2>Revistas</h2>";
} else { 
	$class = 'magazines index row-fluid marginTop40';
	echo "<legend><h2>Revistas</h2></legend>";
}
?>
<div class="<?php echo $class;?>">

	<?php if ($_SESSION['Auth']['Role']['name'] == 'Administrador'): ?>
	<div class="span12">
		<table cellpadding="0" cellspacing="0" class="table table-hover">
			<tr>
				<th>#</th>
				<th><?php echo $this->Paginator->sort('Nombre','name', array('url'=>$url));?></th>
				<th>Articulos</th>
				<th><?php echo $this->Paginator->sort('Fecha de creacion','created', array('url'=>$url));?></th>
				<th class="actions">Acciones</th>
			</tr>
	<?php endif; ?>

	<div class="span8" id="Revistas">
	<!-- Recorre cada una de las revistas -->
	<?php 
	$i = 0;
	foreach ($magazines as $magazine): 

		$contador = 0; //variable para contar los articulos publicados
		foreach ($magazine['Article'] as $articulo) {
			if ($articulo['status'] == 1) $contador = $contador + 1 ;			
		}
		$class = null;
		if ($i++ % 2 == 0) $class = ' class="altrow"';
		if ($_SESSION['Auth']['Role']['name'] == 'Administrador'):
	?>
		<tr<?php echo $class;?>>
			<td><?php echo $i; ?>&nbsp;</td>
			<td><?php echo $this->Html->link($magazine['Magazine']['name'], array('action'=>'view', $magazine['Magazine']['id']));?></td>
			<td><?php echo $contador; ?> Articulos Publicados</td>
			<td><?php echo $magazine['Magazine']['created']; ?></td>
			<td class="actions">
				<?php 
				echo $this->Html->link('Editar', array('action' => 'edit', $magazine['Magazine']['id']))." ";
				echo $this->Html->link('Eliminar', array('action' => 'delete', $magazine['Magazine']['id']), null, '¿Esta seguro que quiere eliminar la revista?'); 
				?>
			</td>
		</tr>
	<?php else: ?>	
	<div id="revista<?php echo $magazine['Magazine']['id']; ?>" class="publication padding20">
		<h3 class="titlePost"><?php echo $this->Html->link($magazine['Magazine']['name'], array('action'=>'view', $magazine['Magazine']['id'])); ?></h3>
		<p  class="pull-right overLegend"><?php echo $contador; ?> Articulos</p>
		<legend class="marginBotton0"></legend>
		<em><?php echo $magazine['Magazine']['created']; ?></em>	
		<p class="space"><?php echo $magazine['Magazine']['description']; ?></p>
	<?php
		$i = 0;
		// recorre cada uno de los usuarios relacionados con la revista
		foreach ($magazine['User'] as $user) {

			// si el usuario es Autor lo muestra en la revista
			if ($user['role_id'] == 2) {
				$author = $user['name']." ".$user['last_names'];
				echo "<em>";
				echo $html->link($author, array('controller' => 'users', 'action' => 'view', $user['id']));
				echo "&nbsp;&nbsp;&nbsp;&nbsp;</em>";
				$i++;
			}
			if ($i >= 4) {
				echo "<em style='color: #0088CC;'>.....</em>";
				break;	
			}			
		}
		if ($_SESSION['Auth']['User']['magazine_id'] == $magazine['Magazine']['id']) {
			echo "<br><button class='btn disabled suscription'>";
			echo $html->image('ok.png', array('style'=>'width: 15px; margin: 0px 5px 5px 0px;'));
			echo "<strong>Suscrito</strong></button>";
		}
		echo "</div>";
		endif;				 
	endforeach;
	?>
		</table>
		<p><?php echo $this->Paginator->counter(array('format' => __('Pagina %page% de %pages%, mostrando %current% registros de un total de %count%, comenzando en el registro %start%, hasta el %end%', true)));	?></p>
		<div class="paging">
			<?php
			$paginator->options(array('url'=> $url));
			echo $this->Paginator->prev('<< Anterior', array(), null, array('class'=>'disabled')).' | ';
			echo $this->Paginator->numbers() .' | ';
			echo $this->Paginator->next('Siguiente >>', array(), null, array('class' => 'disabled')); 
			?>
		</div>
	</div>

	<?php if ($_SESSION['Auth']['Role']['name'] != 'Administrador'): ?>
	<div class="span4">
		<div data-spy="affix" data-offset-top="10">
		<?php
		
		// Mensaje para los visitantes.
		if (empty($_SESSION['Auth'])) echo "<p>".$visitor_ms['Message']['description']."</p>";
		if (!empty($_SESSION['Auth']) && $_SESSION['Auth']['Role']['name'] != 'Administrador') echo "<p>".$user_ms['Message']['description']."</p>";

		echo "<legend></legend>";
		echo "<div class='row-fluid publication'>";
		$adminName = $admin['User']['name']." ".$admin['User']['last_names'];
		$adminSpan = 'span12';
		if ($admin['User']['photo'] != null) {
			echo '<div class="span4">';
			echo $html->image($admin['User']['photo'],array('class'=>'adminImg'));
			echo '</div>';
			$adminSpan = 'span8';
		}
		echo "<div class='".$adminSpan."'>";
		echo "<legend class='marginBotton0'><h5 class='marginBotton0'>";
		echo $this->Html->link($adminName, array('controller'=>'users', 'action'=>'view', $admin['User']['id']));
		echo "</h5></legend>";
		echo "<em class='adminRole'>Administrador</em>";
		echo "<p style='margin-top: 10px'><strong>".$admin['User']['email']."</strong></p>";
		echo "</div>";
		echo "</div>";

		// Formulario de busqueda.
		echo $form->create('Magazine', array('class' => 'form-search'));
		echo $form->input('title', array(
				'label' => false,
				'class' => 'search-query invisible',
				'placeholder' => 'Buscar...', 
				'div' => 'input-append input',
				'after' => '<button id="searchButton" class="btn invisible"><i class="icon-search"></i></button>'
			));
		echo $form->end(array('label'=>'Guardar', 'class'=>'invisible'));
		?>
		</div>
	</div>
	<?php endif; ?>
</div>
