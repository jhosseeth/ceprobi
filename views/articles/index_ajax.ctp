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

		<div id="articulo<?php echo $article['Article']['id']; ?>" class="publication row-fluid">
		<?php
		$span = 'span12';
		if ($article['Article']['photo_article'] != null){
			echo '<div class="span3">';
			echo $html->image($article['Article']['photo_article'],array('class'=>'articleImg'));
			echo '</div>';
			$span = 'span9';
		}
		?>
			<div class="<?php echo $span; ?> padding20">	
				<h5 class="pull-right overLegend"><?php echo $magazineLink;?></h5>	
				<legend class="marginBotton0">
					<h3 class="margin0"><?php echo $articleLink;?></h3>
				</legend>
				<em><?php echo $article['Article']['publication_time'];?></em>
				<p class="space"><?php echo $articulo;?></p>
				Autor: <em><?php echo $authorLink;?></em><br>
				Revisor: <em><?php echo $reviewLink;?></em>			
			</div>	
		</div>
	<?php endforeach; ?>