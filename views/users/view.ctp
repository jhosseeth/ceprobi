<div class="users view row-fluid">
<?php 
$class = 'span10 offset1';
if (!empty($user['User']['photo'])) {	
	echo '<div class="span3">'.$html->image($user['User']['photo'],array('class'=>'')).'</div>';
	$class = 'span9';
}
?>
	<div class="<?php echo $class;?>">
		<?php
		if ($_SESSION['Auth']['Role']['name'] == 'Administrador') {
			echo $this->Html->link('Editar', array('action' => 'edit', $user['User']['id']), array('class'=>'btn btn-primary pull-right'));
			if ($user['Role']['name'] != 'Administrador') echo $this->Html->link('Eliminar', array('action' => 'delete', $user['User']['id']), array('class'=>'btn pull-right', 'style'=>'margin-right: 10px;'), '¿Esta seguro que quiere eliminar la cuenta?'); 
		} elseif ($_SESSION['Auth']['User']['id'] == $user['User']['id']) {
			echo $this->Html->link('Editar', array('action' => 'edit', $user['User']['id']), array('class'=>'btn btn-primary pull-right'));
		}			
		?> 
		<legend><h2><?php  echo $user['User']['name']." ".$user['User']['last_names'];?></h2></legend>
		<?php
		echo "<p>".$user['User']['description']."</p>";
		echo $htmlg->field('Rol', $user['Role']['name']);
		if ($user['Role']['name'] != 'Administrador') echo $htmlg->field('Revista', $user['Magazine']['name'], null, true, array('controller'=>'magazines', 'action'=>'view', $user['Magazine']['id']));
		echo $htmlg->field('Formacion academica', $user['User']['education_degree']);		
		echo $htmlg->field('Lugar de Residencia', $user['User']['adress']);
		echo $htmlg->field('Correo electonico', $user['User']['email']);
		echo $htmlg->field('Fecha de nacimiento', $user['User']['birth_date']);
		if ($user['Role']['name'] != 'Administrador') echo $htmlg->field('Miembro desde', $user['User']['created']);
		?>		
	</div>
</div>
<?php if ($user['Role']['name'] != 'Administrador'):?>
<table cellpadding="0" cellspacing="0" class="table table-hover space">
<tr>
	<th>#</th>
	<th><?php echo $this->Paginator->sort('Artículo','title', array('url'=>$url));?></th>
	<th>
	<?php
	// si es autor pone los revisores de sus articulos, si es revisor pone los autores de los aticulos
	if ($user['Role']['id'] == 2) {	echo $this->Paginator->sort('Revisor','revisor_user_id', array('url'=>$url)); } 
	elseif ($user['Role']['id'] == 3) { echo $this->Paginator->sort('Autor','autor_user_id', array('url'=>$url)); }
	?>
	</th>
	<th><?php echo $this->Paginator->sort('Fecha de publicación','publication_time', array('url'=>$url));?></th>				
</tr>	
<?php
$i = 0;
foreach ($articles as $article):
	$class = null;
	if ($i++ % 2 == 0) $class = ' class="altrow"';	
	if ($user['Role']['id'] == 2) {	
			$linkUser = $html->link($article['RevisorUser']['name']." ".$article['RevisorUser']['last_names'], array('controller' => 'users', 'action' => 'view', $article['RevisorUser']['id']));
		} elseif ($user['Role']['id'] == 3) {
			$linkUser = $html->link($article['AutorUser']['name']." ".$article['AutorUser']['last_names'], array('controller' => 'users', 'action' => 'view', $article['AutorUser']['id']));
		}	
?>
<tr<?php echo $class;?>>
	<td><?php echo $i; ?>&nbsp;</td>
	<td><?php echo $this->Html->link($article['Article']['title'], array('controller'=>'articles', 'action' => 'view', $article['Article']['id'])); ?></td>				
	<td><?php echo $linkUser; ?></td>
	<td><?php echo $article['Article']['publication_time']; ?>&nbsp;</td>
</tr>
<?php endforeach; ?>
</table>
<p><?php echo $this->Paginator->counter(array('format' => __('Página %page% de %pages%, mostrando %current% artículos de un total de %count%, comenzando en el artículo %start% hasta el %end%', true)));	?></p>
<div class="paging">
	<?php
//	$paginator->options(array('url'=> $url));
	echo $this->Paginator->prev('<< Anterior', array(), null, array('class'=>'disabled')).' | ';
	echo $this->Paginator->numbers() .' | ';
	echo $this->Paginator->next('Siguiente >>', array(), null, array('class' => 'disabled')); 
	?>
</div>
<?php endif; ?>