<?php echo $this->Html->script('bootstrap/bootstrap-button');?>
<?php echo $this->Html->script('bootstrap/bootstrap-collapse');?>
<?php echo $this->Html->script('bootstrap/bootstrap-dropdown');?>
<style type="text/css">
[class^="icon-"], [class*=" icon-"] { background-image: url("/img/glyphicons-halflings.png");}
.caret { margin: 3px 0;}
#settingsMenu {
    left: -64%;
    min-width: 130px;
    top: 160%;
}
</style>
<div class="navbar navbar-fixed-top" id="navbar">
	<div class="navbar-inner">

		<?php echo $this->Html->link('Inicio', array('controller'=>'pages', 'action'=>'home'), array('class'=>'brand visible-desktop'));?>

		<!-- El contenido del menu se escondera en una pantalla menor de 940px -->
		<div class="nav-collapse collapse">
			<ul class="nav">
				<li><?php echo $this->Html->link('Revistas', array('controller'=>'magazines','action'=>'index'));?></li>
				<?php if ($_SESSION['Auth']['Role']['name'] == 'Administrador'): ?>
		        <li class="dropdown">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Usuarios <b class="caret"></b></a>
		          <ul class="dropdown-menu">
		            <li><?php echo $this->Html->link('Administrar Usuarios', array('controller'=>'users', 'action'=>'index'));?></li>
		            <li class="divider"></li>
		            <li><?php echo $this->Html->link('Registrar Usuario', array('controller' => 'users', 'action' => 'add'));?></li>
		          </ul>
		        </li>
		    	<?php else: ?>
		    	<li><?php echo $this->Html->link('Usuarios', array('controller'=>'users', 'action'=>'index'));?></li>
		    	<?php endif; ?>
		    	<?php if ($_SESSION['Auth']['Role']['name'] == 'Administrador'): ?>
		    	<li><?php echo $this->Html->link('Articulos', array('controller'=>'articles','action'=>'index'));?></li> 
		    	<li><?php echo $this->Html->link('Mensajes', array('controller'=>'messages','action'=>'index'));?></li>
		    	<?php endif; ?>
			</ul>			
		</div>

		<ul class="nav pull-right">
		<?php 
		if (empty($_SESSION['Auth'])):
			echo $this->Html->link('Iniciar Sesión', array('controller'=>'users', 'action'=>'login'), array('class' => 'btn'));
		elseif (!empty($_SESSION['Auth'])):	
		?>
			<li>
				<strong>
				<?php echo $_SESSION['Auth']['User']['name']." ".$_SESSION['Auth']['User']['last_names']; ?>
				</strong>
				<p><em class="pull-right"><?php echo $_SESSION['Auth']['Role']['name'];?></em></p>
			</li>			
			<li class="divider-vertical"></li>
		    <div class="btn-group">
				<button class="btn disabled"><i class="icon-cog"></i></button>
				<button class="btn dropdown-toggle" data-toggle="dropdown">
					<span class="caret"></span>
				</button>
				<ul id="settingsMenu" class="dropdown-menu">
					<li><?php echo $this->Html->link('Ver Perfil', array('controller'=>'users', 'action'=>'view', $_SESSION['Auth']['User']['id']));?></li>
					<li><?php echo $this->Html->link('Editar Perfil', array('controller'=>'users', 'action'=>'edit', $_SESSION['Auth']['User']['id']));?></li>
					<?php 
					if ($_SESSION['Auth']['Role']['name'] == 'Autor' || $_SESSION['Auth']['Role']['name'] == 'Revisor') echo "<li>".$this->Html->link('Mis Articulos', array('controller'=>'articles','action'=>'index'))."</li>";
					?>
					<li class="divider"></li>
					<li><?php echo "<li>".$this->Html->link('Cerrar Sesión', array('controller'=>'users', 'action'=>'logout'));?></li>
		   		</ul>
			</div>
		<?php endif; ?>	
		</ul>

		<!-- .btn-navbar es usado como el toggle cuando el contenido de la navbar colapsa -->
		<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse" style="float: left;">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</a>
		<?php echo $this->Html->link('Inicio', array('controller'=>'pages'), array('class'=>'brand hidden-desktop'));?>
	</div>
</div>