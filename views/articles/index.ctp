<?php echo $this->Session->flash(); ?>
<div class="articles index">
	<?php 
	if ($_SESSION['Auth']['Role']['name'] == 'Autor') {
		echo $this->Html->link('Crear Articulo', array('action' => 'add'), array('class'=>'pull-right btn btn-primary'));
	}
	?>
	<h2>Control de Artículos</h2>
	 <ul class="nav nav-tabs">
		<li class="active"><?php echo $this->Html->link('Publicados', array('action' => 'index'), array());?></li>
		<li><?php echo $this->Html->link('Pendientes', array('action' => 'index_pending'));?></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active">

			<!-- Articulos Publicados -->
			<table cellpadding="0" cellspacing="0" class="table table-hover">
				<tr>
					<th>#</th>
					<th><?php echo $this->Paginator->sort('Titulo','title', array('url'=>$url));?></th>
					<th><?php echo $this->Paginator->sort('Revista','magazine_id', array('url'=>$url));?></th>
					<?php if ($_SESSION['Auth']['Role']['name'] == 'Administrador'):?>
						<th><?php echo $this->Paginator->sort('Autor','autor_user_id', array('url'=>$url));?></th>
						<th><?php echo $this->Paginator->sort('Revisor','revisor_user_id', array('url'=>$url));?></th>				
						<th><?php echo $this->Paginator->sort('Estado','status', array('url'=>$url));?></th>				
						<th class="actions">Acciones</th>
					<?php elseif ($_SESSION['Auth']['Role']['name'] == 'Autor'):?>
						<th><?php echo $this->Paginator->sort('Revisor','revisor_user_id', array('url'=>$url));?></th>
						<th><?php echo $this->Paginator->sort('Fecha de publicacion','publication_time', array('url'=>$url));?></th>
					<?php elseif ($_SESSION['Auth']['Role']['name'] == 'Revisor'):?>
						<th><?php echo $this->Paginator->sort('Autor','autor_user_id', array('url'=>$url));?></th>
						<th><?php echo $this->Paginator->sort('Fecha de publicacion','publication_time', array('url'=>$url));?></th>
					<?php endif;?>
				</tr>
				<?php
				$i = 0;
				foreach ($articles as $article):

					$class = null;
					if ($i++ % 2 == 0) $class = ' class="altrow"';

					// mostrara todos los articulos al administrador o los articulos asociados al usuario logeado
					if ($_SESSION['Auth']['User']['id'] == $article['Article']['autor_user_id'] || $_SESSION['Auth']['User']['id'] == $article['Article']['revisor_user_id'] || $_SESSION['Auth']['Role']['name'] == 'Administrador'):
						
						$titleLink = $this->Html->link($article['Article']['title'], array('action' => 'view', $article['Article']['id']));
						$magazineLink = $html->link($article['Magazine']['name'], array('controller' => 'magazines', 'action' => 'view', $article['Magazine']['id']));
						$authorLink = $html->link($article['AutorUser']['name']." ".$article['AutorUser']['last_names'], array('controller' => 'users', 'action' => 'view', $article['AutorUser']['id']));
						$reviewLink = $html->link($article['RevisorUser']['name']." ".$article['RevisorUser']['last_names'], array('controller' => 'users', 'action' => 'view', $article['RevisorUser']['id']));
						if ($article['Article']['status'] == 1 ) $status = 'Publicado';
				?>
				<tr<?php echo $class;?>>
					<td><?php echo $i; ?>&nbsp;</td>
					<td><?php echo $titleLink; ?>&nbsp;</td>
					<td><?php echo $magazineLink;?></td>
					<?php if ($_SESSION['Auth']['Role']['name'] == 'Administrador'):?>
						<td><?php echo $authorLink;?></td>
						<td><?php echo $reviewLink;?></td>
						<td><?php echo $status; ?>&nbsp;</td>
						<td class="actions">
						<?php
						echo $this->Html->link('Editar', array('action' => 'edit', $article['Article']['id']))." ";
						echo $this->Html->link('Eliminar', array('action' => 'delete', $article['Article']['id']), null, '¿Esta seguro que quiere eliminar el articulo?');
						?>
						</td>
					<?php elseif ($_SESSION['Auth']['Role']['name'] == 'Autor'):?>
						<td><?php echo $reviewLink;?></td>
						<td><?php echo $article['Article']['publication_time'];?></td>
					<?php elseif ($_SESSION['Auth']['Role']['name'] == 'Revisor'):?>
						<td><?php echo $authorLink;?></td>				
						<td><?php echo $article['Article']['publication_time'];?></td>
					<?php endif;?>			
				</tr>
				<?php endif;?>
			<?php endforeach; ?>
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
	</div>	
</div>