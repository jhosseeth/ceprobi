<?php //echo $this->Html->script('bootstrap/bootstrap-affix'); ?>
<?php echo $this->Html->script('bootstrap/bootstrap-alert'); ?>
<?php echo $this->Html->script('bootstrap/bootstrap-button');?>
<?php echo $this->Html->script('bootstrap/bootstrap-modal'); ?>
<script type="text/javascript">
	$(document).ready(function() {

        <?php if ($_SESSION['Auth']['User']['subscription'] < 0): ?>

        	$('#modalDecline').modal('show');

        <?php elseif (!empty($_SESSION['Auth']) && $_SESSION['Auth']['User']['subscription'] == $_SESSION['Auth']['User']['magazine_id']): ?>

        	$('#myModal').modal('show');

        <?php endif; ?>
    });
</script>
<style type="text/css">	
	.ipn { max-height: 200px;} 
	.banner div { margin-left: 0px;}
</style>
<div class="banner">
	<div class="row-fluid">
		<div class="span3" style="width: 18%;"><?php echo $html->image('ipn.jpg',array('class'=>'ipn'));?></div>
		<div class="span9" style="padding-top: 20px;">
			<legend><h5><?php echo $title_ms['Message']['description'];?></h5></legend>
			<?php echo $html->image('ceprobi.jpg',array('class'=>'pull-right'));?>
			<p><?php echo $general_ms['Message']['description'];?></p>
		</div>
	</div>			
</div>
<?php echo $this->Session->flash(); ?>
<h1>Últimas Actualizaciones</h1>

<div class="row-fluid space">
	<div class="span8" id="Articulos">
		<?php 
		$i = 0;
		foreach ($articles as $article ):
			$class = null;
			if ($i++ % 2 == 0) $class = ' class="altrow"';
			$magazineLink = $html->link($article['Magazine']['name'], array('controller' => 'magazines', 'action' => 'view', $article['Magazine']['id']));
			$articleLink = $html->link($article['Article']['title'], array('controller' => 'articles', 'action' => 'view', $article['Article']['id']));
			$authorLink = $html->link($article['AutorUser']['name']." ".$article['AutorUser']['last_names'], array('controller' => 'users', 'action' => 'view', $article['AutorUser']['id']));
			$reviewLink = $html->link($article['RevisorUser']['name']." ".$article['RevisorUser']['last_names'], array('controller' => 'users', 'action' => 'view', $article['RevisorUser']['id']));
			$articulo = $article['Article']['description'].$html->link(' leer mas ...', array('controller' => 'articles', 'action' => 'view', $article['Article']['id']));

		?> 

		<div id="articulo<?php echo $article['Article']['id']; ?>" class="publication row-fluid extr_padding">
		<?php
		$span = 'span12 lat_padding';
		if ($article['Article']['photo_article'] != null){
			echo '<div class="span3 Lpadding20">';
			echo $html->image($article['Article']['photo_article'],array('class'=>'articleImg'));
			echo '</div>';
			$span = 'span9 Rpadding20';
		}
		?>
			<div class="<?php echo $span; ?>">	
				<h3 class="titlePost"><?php echo $articleLink;?></h3>
				<h5 class="pull-right overLegend"><?php echo $magazineLink;?></h5>	
				<legend class="marginBotton0"></legend>
				<em><?php echo $article['Article']['publication_time'];?></em>
				<p class="space"><?php echo $articulo;?></p>
				Autor: <em><?php echo $authorLink;?></em><br>
				Revisor: <em><?php echo $reviewLink;?></em>			
			</div>	
		</div>
	<?php endforeach; ?>

		<p><?php echo $this->Paginator->counter(array('format' => __('Página %page% de %pages%, mostrando %current% artículos de un total de %count%, comenzando en el artículo %start% hasta el %end%', true)));	?></p>
		<div class="paging">
			<?php
//			$paginator->options(array('url'=> $url));
			echo $this->Paginator->prev('<< Anterior', array(), null, array('class'=>'disabled')).' | ';
			echo $this->Paginator->numbers() .' | ';
			echo $this->Paginator->next('Siguiente >>', array(), null, array('class' => 'disabled')); 
			?>
		</div>
	</div>

	<div class="span4">
		<div data-spy="affix" data-offset-top="200">
		<?php
		
		// Mensaje para los visitantes.
		if (empty($_SESSION['Auth'])) {
			echo "<p>".$visitor_ms['Message']['description']."</p>";
			echo $this->Html->link('Registrarse', array('controller' => 'users', 'action' => 'add'), array('class' => 'btn btn-info', 'style' => 'margin-bottom: 20px;'));
		}
		
		// Notificaciones para los usuarios.
		$infoImg = '<div class="messageImg">'.$html->image('info.png').'</div>'; // Imagen de información
		if ($_SESSION['Auth']['Role']['name'] == 'Administrador') {
			$contador = 0; //variable para contar los articulos pendientes de revisor
			foreach ($pendingArticles as $item) { if ($item['Article']['revisor_user_id'] == null) $contador = $contador + 1; }
			if (count($pendingUsers) != 0) echo '<div class="alert alert-info">'.$infoImg.'<p>Tiene '.count($pendingUsers).' usuarios pendientes por activacion</p></div>';
			if ($contador != 0) echo '<div class="alert alert-info">'.$infoImg.'<p>Tiene '.$contador.' articulos pendientes por asignar Revisor</p></div>';
			if (count($pendingUsersSus) != 0) echo '<div class="alert alert-info">'.$infoImg.'<p>Tiene '.count($pendingUsersSus).' usuarios que han solicitado cambio de suscripción</p></div>';
			if (count($pendingArticles) != 0) echo '<div class="alert alert-info">'.$infoImg.'<p>Hay '.count($pendingArticles).' articulos pendientes por publicar</p></div>';
		} elseif ($_SESSION['Auth']['Role']['name'] == 'Autor') {
			$contador = 0; //variable para contar los articulos pendientes de revisor
			foreach ($pendingArticles as $item) { if ($item['Article']['revisor_user_id'] == null) $contador = $contador + 1; }
			if ($contador != 0) echo '<div class="alert alert-info">'.$infoImg.'<p>Tiene '.$contador.' articulos esperando a que se le asigne Revisor</p></div>';
			if (count($pendingArticles) != 0) echo '<div class="alert alert-info">'.$infoImg.'<p>Tiene '.count($pendingArticles).' articulos pendientes por revision</p></div>';
			
		} elseif ($_SESSION['Auth']['Role']['name'] == 'Revisor') {
			if (count($pendingArticles) != 0) echo '<div class="alert alert-info">'.$infoImg.'<p>Tiene '.count($pendingArticles).' articulos pendientes para revisar y/o publicar</p></div>';
		}

		echo "<legend></legend>";
		if ($_SESSION['Auth']['Role']['name'] != 'Administrador') {
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
		}	

		// Formulario de busqueda.
		echo $form->create('Article', array('class' => 'form-search'));
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
</div>

<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">
			<?php echo $html->image('careful.png', array('style'=>'width: 30px;'));?>
			Notificación
		</h3>
	</div>

	<div class="modal-body">
	<?php $op = $_SESSION['Auth']['User']['subscription']; ?>
		<p>El <em>Administrador</em> ha confirmado su suscripción a la revista: <strong><?php echo $magazines[$op];?></strong>.</p>
		<p>De ahora en adelante todo los articulos que hagas serán publicados en esta Revista.</p>
		<p class="muted space" style="font-size: 13px;">Para más información puede ponerse en contacto con el <em>Administrador</em> a traves del correo electrónico: <strong><?php echo $admin['User']['email'];?></strong></p>
	</div>

	<div class="modal-footer">
		<?php echo $html->link('<strong>Confirmar</strong>', array('controller' => 'users', 'action' => 'subscribe', $_SESSION['Auth']['User']['id'], 0), array('class'=>'btn btn-warning', 'escape'=>false));?>
	</div>
</div>

<!-- Modal Rechazo-->
<div id="modalDecline" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">
			<?php echo $html->image('careful.png', array('style'=>'width: 30px;'));?>
			Notificación
		</h3>
	</div>

	<div class="modal-body">
	<?php $op = $_SESSION['Auth']['User']['subscription'] * -1;	?>
		<p>El <em>Administrador</em> ha rechazado su suscripción a la revista: <strong><?php echo $magazines[$op];?></strong>.</p>
		<p class="muted space" style="font-size: 13px;">Para más información puede ponerse en contacto con el <em>Administrador</em> a traves del correo electrónico: <strong><?php echo $admin['User']['email'];?></strong></p>
	</div>

	<div class="modal-footer">
		<?php echo $html->link('<strong>Confirmar</strong>', array('controller' => 'users', 'action' => 'subscribe', $_SESSION['Auth']['User']['id'], 0), array('class'=>'btn btn-warning', 'escape'=>false));?>
	</div>
</div>