<?php
echo $this->Html->css('autoSuggest');
echo $this->Html->script('jquery.autoSuggest');
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
		$('.error-message').siblings('select').after('<img class="validateImg" src="' + baseUrl + '/img/error.png">');

	});
</script>
<div class="articles form">
<?php 
if ($_SESSION['Auth']['Role']['name'] == 'Administrador') {
	echo $html->link('Eliminar', array('action' => 'delete', $this->Form->value('Article.id')), array('class'=>'btn pull-right'), sprintf(__('Estas seguro que quieres borrar el articulo: %s?', true), $this->Form->value('Article.title')));
}
echo $form->create('Article', array('type'=>'file'));
?>
	<fieldset>
		<legend>Editar Artículo</legend>
<?php
$this->log($this->Form->value('Article.revisor_user_id'), LOG_DEBUG);
$dis = false;
if ($_SESSION['Auth']['Role']['name'] == 'Administrador') $dis = true;
echo $form->input('id', array('label'=>'Id', 'size'=>'11', 'maxlength'=>'11',));
echo $form->input('title', array('label'=>'Titulo', 'size'=>'40', 'maxlength'=>'90', 'disabled'=>$dis));
echo $form->input('description', array('label'=>'Descripcion', 'cols'=>'60', 'rows'=>'6',  'disabled'=>$dis));
if ($_SESSION['Auth']['Role']['name'] == 'Administrador') {	
	echo $form->input('revisor_user_id', array('label'=>'Revisor',  'empty'=>'Seleccione...'));
} else {
	echo $form->input('article', array('label'=>'Artículo', 'type' => 'file'));
	echo $form->input('photo_article', array('label'=>'Foto', 'type' => 'file', 'size'=>'40', 'maxlength'=>'255',));
	echo $form->input('magazine_id', array('type'=>'hidden', 'value'=>$_SESSION['Auth']['User']['magazine_id']));
	echo $form->input('autor_user_id', array('type'=>'hidden', 'value'=>$_SESSION['Auth']['User']['id']));
}
?>
	</fieldset>
<?php echo $form->end(array('class'=>'btn btn-primary space', 'label'=>'Guardar'));?>
</div>