<?php 
if ($_SESSION['Auth']['Role']['name'] == 'Administrador') {
	echo $this->Html->link('Eliminar Artículo', array('action' => 'delete', $article['Article']['id']), array('class'=>'pull-right btn break-line'), 'Esta seguro de borrar '.$article['Article']['title'].' ?');
} elseif ($_SESSION['Auth']['Role']['name'] == 'Autor' && $article['Article']['status'] == 0) {
	echo $this->Html->link('Editar Artículo', array('action' => 'edit', $article['Article']['id']), array('class'=>'pull-right btn btn-primary'));
} elseif ($_SESSION['Auth']['Role']['name'] == 'Revisor') {
	echo $this->Html->link('Publicar Artículo', array('action' => 'publicar', $article['Article']['id']), array('class'=>'pull-right btn break-line'));
}
?>
<div class="articles view row-fluid">
	<?php 
	$class = 'span10 offset1';
	if (!empty($article['Article']['photo_article'])) {	
		echo '<div class="span4">'.$html->image($article['Article']['photo_article'],array('class'=>'')).'</div>';
		$class = 'span8';
	}
	?>
	<div class="<?php echo $class;?>">
		<legend><h2 class="marginBotton0"><?php echo $article['Article']['title']; ?></h2></legend>
		<?php
		$revista = $article['Magazine']['name'];
		$autor = $article['AutorUser']['name']." ".$article['AutorUser']['last_names'];
		$revisor = $article['RevisorUser']['name']." ".$article['RevisorUser']['last_names'];
		$imageFile = $html->image('article.png',array('class'=>''));
		$fileArticle = str_replace("/files/", "", $article['Article']['article']);
		echo "<p>".$article['Article']['description']." ...</p>";
		if (!empty($_SESSION['Auth'])) 	echo $htmlg->field('Fecha de creacion', $article['Article']['created']);
		if ($article['Article']['modified'] != null && !empty($_SESSION['Auth'])) echo $htmlg->field('Ultima actualizacion', $article['Article']['modified']);
		if ($article['Article']['publication_time'] != null) echo $htmlg->field('Fecha de publicacion', $article['Article']['publication_time']);
		echo $htmlg->field('Autor', $autor, true, array('controller'=>'users', 'action'=>'view', $article['AutorUser']['id']));
		echo $htmlg->field('Revisor', $revisor, true, array('controller'=>'users', 'action'=>'view', $article['RevisorUser']['id']));	
		echo $htmlg->field('Revista', $revista, true, array('controller'=>'magazines','action'=>'view', $article['Magazine']['id']));
		if ($_SESSION['Auth']['Role']['name'] == 'Administrador' || $_SESSION['Auth']['User']['id'] == $article['Article']['autor_user_id'] || $_SESSION['Auth']['User']['id'] == $article['Article']['revisor_user_id']) {
			echo $html->image('article.png');
			echo $this->Html->link('Descargar Artículo', array('action'=>'download', $article['Article']['title'], $fileArticle));
		}
		if (!$_SESSION['Auth']) {
			$notifImg = '<div class="messageImg">'.$html->image('careful.png').'</div>';
			echo '<p><em>'.$visitor_ms['Message']['description'].'</em> <strong>'.$article['AutorUser']['email'].'</strong></p>';
			echo '<div class="alert">'.$notifImg.'<p>'.$visitor_nt['Message']['description'].'</p></div>';
		}
			
		?>
	</div>
</div>
<div class="space">
<?php 
foreach ($tags as $tag) {
	echo '<div id="'.$tag['Tag']['id'].'" class="tag btn btn-info disabled">';
	echo '<strong>'.$tag['Tag']['name'].'</strong></div>';
}
?>
</div>
