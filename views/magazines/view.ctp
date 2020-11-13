<?php
echo $this->Html->script('bootstrap/bootstrap-alert');
echo $this->Session->flash();

if (!empty($_SESSION['Auth']) && $_SESSION['Auth']['Role']['name'] != 'Administrador') {
	if ($_SESSION['Auth']['User']['magazine_id'] == $magazine['Magazine']['id']) {
		echo "<button class='btn disabled suscription pull-right'>";
		echo $html->image('ok.png', array('style'=>'width: 15px; margin: 0px 5px 5px 0px;'));
		echo "<strong>Suscrito</strong></button>";
	} elseif ($_SESSION['Auth']['User']['subscription'] == $magazine['Magazine']['id']) {
		echo "<button class='btn disabled suscription pull-right' title='Debe esperar a que el Adminisrador confirme la suscripción'>";
		echo $html->image('ok1.png', array('style'=>'width: 19px; margin-right: 5px;'));
		echo "<strong>Suscripción Pendiente</strong></button>";
	} else {
		$suscribrirse = $html->image('addGrey.png', array('style'=>'width: 18px; margin: 0px 10px 1px 0px;'))."<strong>Suscribrirse</strong>";
		echo $html->link($suscribrirse, array('controller' => 'users', 'action' => 'subscribe', $_SESSION['Auth']['User']['id'], $magazine['Magazine']['id']), array('class'=>'btn suscription pull-right', 'escape'=>false));
	}
}	
?>
<div class="magazines view">
	<legend><h2><?php  echo $magazine['Magazine']['name'];?></h2></legend>
	<p><?php  echo $magazine['Magazine']['description'];?></p>
	<div class="row-fluid marginTop40">
		<div class="span10 offset1" id="ArticulosRevista">
		<?php 
		foreach ($articles as $article ): 
			$articleLink = $html->link($article['Article']['title'], array('controller' => 'articles', 'action' => 'view', $article['Article']['id']));
			$authorLink = $html->link($article['AutorUser']['name']." ".$article['AutorUser']['last_names'], array('controller' => 'users', 'action' => 'view', $article['AutorUser']['id']));
			$reviewLink = $html->link($$article['RevisorUser']['name']." ".$article['RevisorUser']['last_names'], array('controller' => 'users', 'action' => 'view', $article['RevisorUser']['id']));
		?> 
			<div id="article<?php echo $article['Article']['id']; ?>" class="publication row-fluid extr_padding">
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
					<legend class="marginBotton0"></legend>
					<em><?php echo $article['Article']['publication_time'];?></em>
					<p class="space"><?php echo $article['Article']['description'];?></p>
					Autor: <em><?php echo $authorLink;?></em><br>
					Revisión por: <em><?php echo $reviewLink;?></em>
				</div>	
			</div>
		<?php endforeach; ?>		
		</div>	
	</div>
	<p><?php echo $this->Paginator->counter(array('format' => __('Página %page% de %pages%, mostrando %current% artículos de un total de %count%, comenzando en el artículo %start% hasta el %end%', true)));	?></p>
	<div class="paging">
		<?php
//		$paginator->options(array('url'=> $url));
		echo $this->Paginator->prev('<< Anterior', array(), null, array('class'=>'disabled')).' | ';
		echo $this->Paginator->numbers() .' | ';
		echo $this->Paginator->next('Siguiente >>', array(), null, array('class' => 'disabled')); 
		?>
	</div>
</div>