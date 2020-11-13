<?php 
foreach ($recentArticles as $article ):
	if ($article['Article']['status'] == 1): // muestra solo los articulos habilitados
	$photo = $article['Article']['photo_article'];
	$magazineLink = $html->link($article['Magazine']['name'], array('controller' => 'magazines', 'action' => 'view', $article['Magazine']['id']));
	$articleLink = $html->link($article['Article']['title'], array('controller' => 'articles', 'action' => 'view', $article['Article']['id']));
	$authorLink = $html->link($article['AutorUser']['name']." ".$article['AutorUser']['last_names'], array('controller' => 'users', 'action' => 'view', $article['AutorUser']['id']));
	$reviewLink = $html->link($article['RevisorUser']['name']." ".$article['RevisorUser']['last_names'], array('controller' => 'users', 'action' => 'view', $article['RevisorUser']['id']));
	$articulo = $article['Article']['description'].$html->link(' leer mas ...', array('controller' => 'articles', 'action' => 'view', $article['Article']['id']));
?> 

<div id="articulo<?php echo $article['Article']['id']; ?>" class="publication row-fluid">
		
	<div class="span3">
	<?php echo $html->image('img4.jpg',array('class'=>'articleImg pull-left'));?>						
	</div>
	<div class="span9 padding20">	
		<h6 class="pull-right overLegend"><?php echo $magazineLink;?></h6>	
		<legend class="marginBotton0">
			<h3 class="margin0 a"><?php echo $articleLink;?></h3>
		</legend>
		<em><?php echo $article['Article']['publication_time'];?></em>
		<p class="space"><?php echo $articulo;?></p>
		Autor: <em><?php echo $authorLink;?></em><br>
		Revisor: <em><?php echo $reviewLink;?></em>			
	</div>	
</div>

	<?php endif;?>
<?php endforeach;?>