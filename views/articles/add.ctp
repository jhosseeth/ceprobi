<?php
echo $this->Html->css('autoSuggest');
echo $this->Html->script('jquery.autoSuggest');
echo $this->Html->script('bootstrap/bootstrap-alert');
?>
<script type="text/javascript">
	$(function() {

		// Esitlo para la validacion del CakePHP
		$('.error-message')
			.addClass('text-error')
			.css({
				'margin-top' : '-10px',
				'margin-bottom' : '8px'
			});
		$('.error-message').siblings('input').after('<img class="validateImg" src="' + baseUrl + '/img/error.png">');

	});
</script>
<div class="articles form">
<?php 
echo $form->create('Article', array('type'=>'file'));

echo "<div class='alert alert-info'>";
echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
echo '<div class="messageImg">'.$html->image('info.png').'</div>';
echo "<p class='margin0'>El artículo se creará en la Revista: <strong>";
echo $magazines[$_SESSION['Auth']['User']['magazine_id']] . "</strong></p>";
echo "<p>Si deseas cambiar de revista comunicate con el Administrador ó suscríbete a alguna de nuestras revistas.</p>";
echo "</div>";
?>
	<fieldset>
		<legend>Crear Artículo</legend>
		
<?php
echo $form->input('title', array('label'=>'Titulo', 'size'=>'40', 'maxlength'=>'90',));
echo $form->input('description', array('label'=>'Descripcion', 'cols'=>'60', 'rows'=>'6'));
echo $form->input('article', array('label'=>'Artículo', 'type'=>'file'));
echo $form->input('photo_article', array('label'=>'Foto', 'type'=>'file', 'size'=>'40', 'maxlength'=>'255'));
if ($_SESSION['Auth']['Role']['name'] == 'Administrador') {		
	echo $form->input('magazine_id', array('label'=>'Revista', 'div'=>'input select space', 'empty'=>'Seleccione...'));
	echo $form->input('autor_user_id', array('label'=>'Autor',  'empty'=>'Seleccione...'));	
	echo $form->input('revisor_user_id', array('label'=>'Revisor',  'empty'=>'Seleccione...'));
} else {
	echo $form->input('magazine_id', array('type'=>'hidden', 'value'=>$_SESSION['Auth']['User']['magazine_id']));
	echo $form->input('autor_user_id', array('type'=>'hidden', 'value'=>$_SESSION['Auth']['User']['id']));
}
?>
	</fieldset>
<?php 
echo $form->end(array('class'=>'btn btn-primary space', 'label'=>'Guardar'));
?>
</div>