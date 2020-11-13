<?php echo $this->Html->script('bootstrap/bootstrap-alert'); ?>
<?php echo $this->Session->flash(); ?>
<legend><h2>Usuarios</h2></legend>
<?php 
if ($_SESSION['Auth']['Role']['name'] == 'Administrador'):
	$class = 'users row-fluid';
?>
<p>Para <strong>agregar</strong> un usuario, dirijase al menú <em>Usuarios -> Registrar Usuario.</em></p>
<p>La ordenación se ha integrado fácilmente en las cabeceras de las columnas de las tablas, esto permite que al hacer click en uno de los enlaces, se pueda alternar la ordenación de los datos por un campo dado.</p>
<?php 
else:
	$class = 'users row-fluid marginTop40';
endif;
?>

<div class="<?php echo $class;?>">

<?php if ($_SESSION['Auth']['Role']['name'] == 'Administrador'): ?>
	<div class="span12">
	<table cellpadding="0" cellspacing="0" class="table table-hover">
		<tr>
			<th>#</th>
			<th><?php echo $this->Paginator->sort('Nombre','name', array('url'=>$url));?></th>
			<th><?php echo $this->Paginator->sort('Usuario','username', array('url'=>$url));?></th>
			<th><?php echo $this->Paginator->sort('Correo','email', array('url'=>$url));?></th>
			<th><?php echo $this->Paginator->sort('Rol','role_id', array('url'=>$url));?></th>
			<th><?php echo $this->Paginator->sort('Estado','status', array('url'=>$url));?></th>
			<th><?php echo $this->Paginator->sort('Suscripción','subscription', array('url'=>$url));?></th>
			<th><?php echo $this->Paginator->sort('Miembro desde','created', array('url'=>$url));?></th>
			<th class="actions"><?php echo "Acciones";?></th>
		</tr>	
<?php
endif;
echo '<div class="span9 offset1">';
$i = 0;
foreach ($users as $user):
	$class = null;	
	$usuario = $user['User']['name']." ".$user['User']['last_names'];
	if ($i++ % 2 == 0) $class = ' class="altrow"';
	if ($user['User']['status'] == 1) { 
		$status = 'Activo'; 
		$activacion = $this->Html->link('Deshabilitar', array('action' => 'activacion', $user['User']['id'], 0));
	} elseif ($user['User']['status'] == 0) { 
		$status = 'Pendiente';
		$activacion = $this->Html->link('Habilitar', array('action' => 'activacion', $user['User']['id'], 1));
	}
	$t = null;
	if ($user['User']['subscription'] == 0 || $user['User']['subscription'] == $user['User']['magazine_id']) { 
		$suscription = "------------"; 
		$t = "El usuario no ha solicitado ser suscrito a otra revista.";
	} elseif ($user['User']['subscription'] > 0) { 
		$suscription = "Pendiente"; 
		$t = "El usuario ha solicitado ser suscrito a otra revista.";
	} elseif ($user['User']['subscription'] < 0) { 
		$suscription = "Rechazada";
		$t = "Suscripción rechazada y en espera de que el usuario sea notificado satisfactoriamente.";
	}

	if ($_SESSION['Auth']['Role']['name'] == 'Administrador'):
?>	
		<tr<?php echo $class;?>>
			<td><?php echo $i; ?>&nbsp;</td>
			<td><?php echo $this->Html->link($usuario, array('action'=>'view', $user['User']['id'])); ?>&nbsp;</td>
			<td><?php echo $user['User']['username']; ?>&nbsp;</td>
			<td><?php echo $user['User']['email']; ?>&nbsp;</td>
			<td><?php if ($user['Role']['name'] == 'Administrador'){echo "Admin";} else { echo $user['Role']['name'];} ?></td>
			<td><?php echo $status; ?>&nbsp;</td>
			<td title="<?php echo $t; ?>"><?php echo $suscription; ?></td>
			<td><?php echo $user['User']['created']; ?>&nbsp;</td>
			<td class="actions">
				<?php 
				echo $this->Html->link('Editar', array('action' => 'edit', $user['User']['id']))." ";
				if ($user['Role']['name'] != 'Administrador') {
					echo $this->Html->link('Eliminar', array('action' => 'delete', $user['User']['id']), null, '¿Esta seguro que quiere eliminar la cuenta?'); 				
					echo " ".$activacion;
				}
					
				?>
			</td>
		</tr>
<?php 
	else:			
		if ($user['User']['status'] == 1): // solo mostrara los usuarios activos
?>
		<div id="usuario<?php echo $user['User']['id']; ?>" class="publication row-fluid">
		<?php
		$span = 'span12 lat_padding';
			if ($user['User']['photo'] != null){
				echo '<div class="span3">';
				echo $html->image($user['User']['photo'],array('class'=>'userImg'));
				echo '</div>';
				$span = 'span9 Rpadding20';
			}
		?>
			<div class="<?php echo $span; ?>">
				<h3 class="marginBotton0"><?php echo $this->Html->link($usuario, array('action'=>'view', $user['User']['id'])); ?></h3>
				<em class="pull-right overLegend"><?php echo $user['Role']['name']; ?></em>	
				<legend></legend>
				<p><?php echo $user['User']['description'];?></p>
				<p><strong>Correo electronico: </strong><?php echo $user['User']['email'];?></p>
			</div>				
		</div>
<?php 
		endif;
	endif;
endforeach; 

echo "</table>";
echo "</div></div>";
if ($_SESSION['Auth']['Role']['name'] == 'Administrador') {
	echo "<p>";
	echo $this->Paginator->counter( array('format' => __('Pagina %page% de %pages%, mostrando %current% registros de un total de %count%, comenzando en el registro %start%, hasta el %end%', true)));
	echo '</p>';
}	
echo '<div class="paging">';
$paginator->options(array('url'=> $url));
echo $this->Paginator->prev('<< Anterior', array(), null, array('class'=>'disabled')).' | ';
echo $this->Paginator->numbers() .' | ';
echo $this->Paginator->next('Siguiente >>', array(), null, array('class' => 'disabled')); 
echo "</div>";
?>
</div>