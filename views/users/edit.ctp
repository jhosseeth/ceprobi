<script type="text/javascript">
	$(function() {

		// Limpia el campo de las contraseñas si hay algun problema de validación
		if ($('.error-message').length > 0) {
			$('#UserPassword').val('');
			$('#UserPasswordConfirm').val('');
		};

		var userName = $('#UserUsername').val();
		$('#UserDisableUsername').val(userName);

		// Formato a la Fecha de Nacimiento
		$('#UserBirthDateDay').addClass('input-mini');
		$('#UserBirthDateMonth').addClass('input-medium');
		$('#UserBirthDateYear').addClass('input-small');
		$('#UserBirthDateMonth').children('option[value=01]').html('Enero');
		$('#UserBirthDateMonth').children('option[value=02]').html('Febrero');
		$('#UserBirthDateMonth').children('option[value=03]').html('Marzo');
		$('#UserBirthDateMonth').children('option[value=04]').html('Abril');
		$('#UserBirthDateMonth').children('option[value=05]').html('Mayo');
		$('#UserBirthDateMonth').children('option[value=06]').html('Junio');
		$('#UserBirthDateMonth').children('option[value=07]').html('Julio');
		$('#UserBirthDateMonth').children('option[value=08]').html('Agosto');
		$('#UserBirthDateMonth').children('option[value=09]').html('Septiembre');
		$('#UserBirthDateMonth').children('option[value=10]').html('Octubre');
		$('#UserBirthDateMonth').children('option[value=11]').html('Noviembre');
		$('#UserBirthDateMonth').children('option[value=12]').html('Diciembre');

		var submitable = true;

		// Valida tamaño de contraseña
		$('#UserPassword').on('keyup', function() {

			$('#passwordValidate').remove();
			var passwordSize = $(this).val().length;
			if (passwordSize < 5) {
				var errorMessage = '<img class="validateImg" id="passwordValidate" src="' + baseUrl + '/img/error.png" title="La contraseña debe tener al menos 5 caracteres">';
				$(this).after(errorMessage);
			};
		});

		// Valida que las contraseñas sean iguales
		$('#UserPasswordConfirm').on('focusout', function(e) {

			$('#confirmPassword').remove();
			var validated = true;
			if ($(this).val() != $('#UserPassword').val()) { validated = false; };
			if ($('#UserPassword').val() == '') { validated = null; };
			if(validated == false) {
				var errorMessage = '<img class="validateImg" id="confirmPassword" src="' + baseUrl + '/img/error.png" title="Las contraseñas deben coincidir">';
				$(this).after(errorMessage);
			} else if (validated == true) {
				var successMessage = '<img class="validateImg" id="confirmPassword" src="' + baseUrl + '/img/success.png" title="Las contraseñas coinciden">';
				$(this).after(successMessage);
			};				
		});			

		// Valida el formulario
		$('form').on('submit', function() {
			var passwordVal = $.trim($('#UserPassword').val());
			var passwordSize = $('#UserPassword').val().length;
			var passwordConfirmVal = $.trim($('#UserPasswordConfirm').val());
			if (passwordVal != '' && passwordSize < 5) { 
				alert('La contraseña debe tener al menos 5 caracteres'); 
				return false;
			} else if (passwordSize >= 5) { 
				if (passwordVal != passwordConfirmVal) { 
					alert('Las contraseñas no coinciden'); 
					return false;
				};
			};
			return submitable;			
		});

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
<div class="users form">
<?php echo $form->create('User', array('type'=>'file'));?>
	<fieldset>
		<legend>Editar Usuario</legend>
		<div id="message"></div>
		<?php
		echo $form->input('username', array('type'=>'hidden'));
		echo $form->input('name', array(
			'label'=>'Nombre', 
			'div'=>'input text pull-left', 
			'maxlength'=>'45',
			));
		echo $form->input('last_names', array('label'=>'Apellidos', 'maxlength'=>'45',));
		echo $form->input('email', array(
			'label'=>'Correo', 
			'div'=>'input text pull-left break-line', 
			'placeholder'=>'example@magazine.com'
			));
		echo $form->input('disableUsername', array(
			'label'=>'Usuario', 
			'title'=>'El nombre de usuario es unico para cada usuario y no puede ser cambiado.',
			'div'=>'input text pull-left', 
			'maxlength'=>'32',
			'disabled'=>true
			));	
		echo $form->input('adress', array(
			'label'=>'Lugar de Residencia', 
			'div'=>'input text pull-left break-line', 
			'size'=>'40', 
			'maxlength'=>'45',
			));
		echo $form->input('education_degree', array(
			'label'=>'Estudios o formacion academica', 
			'div'=>'input text pull-left', 
			'size'=>'40', 
			'maxlength'=>'255',
			));
		echo $form->input('description', array(
			'label'=>'Descripcion', 
			'div'=>'input textarea break-line', 
			'cols'=>'53', 
			'rows'=>'4'
			));
		echo $form->input('birth_date', array(
			'label'=>'Fecha de Nacimiento',
			'dateFormat' => 'DMY', 
			'minYear'=> date('Y') - 90,
			'maxYear'=> date('Y') - 15,
			));
		echo $form->input('photo', array(
			'label'=>'Foto', 
			'type' => 'file', 
			'size'=>'40', 
			'maxlength'=>'255',
			));			
		if ($_SESSION['Auth']['Role']['name'] == 'Administrador') {
			echo "<legend class='space'>Reestablecer Contraseña</legend>";
			echo $form->input('password', array(
				'label'=>'Contraseña', 
				'div'=>'input password pull-left', 
				'size'=>'32', 
				'maxlength'=>'32',
				));
			echo $form->input('passwordConfirm', array(
				'label'=>'Confirmar contraseña', 
				'type'=>'password', 
				'size'=>'32', 
				'maxlength'=>'32',
				));
			if ($this->Form->value('User.id') != $_SESSION['Auth']['User']['id']) {
				echo "<legend class='space'></legend>";
				if ($this->Form->value('User.subscription') > 0 && $this->Form->value('User.subscription') != $this->Form->value('User.magazine_id')) {
					$uId = $this->Form->value('User.id');
					$op1 = $this->Form->value('User.subscription') * 2;
					$mId = $this->Form->value('User.subscription') - $op1;

					echo "<div class='alert' style='border: 1px solid #FFD891'>";
					echo '<div class="messageImg">'.$html->image('careful.png').'</div>';
					echo "<p>El usuario solicitó cambio de suscripción a la Revista: <strong>";
					echo $magazines[$this->Form->value('User.subscription')] . "</strong></p>";
					echo $html->link('<strong>Rechazar</strong>', array('controller' => 'users', 'action' => 'subscribe', $uId, $mId), array('class'=>'btn btn-small btn-warning pull-right', 'escape'=>false));
					echo "<p>Puede cambiar la Revista y guardar para confirmar ó puede rechazar la suscripción.</p>";
					echo "</div>";
				}
				echo $form->input('role_id', array(
					'label'=>'Rol', 
					'div'=>'input select pull-left', 
					'empty'=>'Seleccione...'
					));
				echo $form->input('magazine_id', array(
					'label'=>'Revista', 
					'empty'=>'Seleccione...'
					));
				echo $form->input('status', array(
					'type' => 'checkbox', 
					'div'=>'input checkbox pull-left', 
					'label'=>false,
					'after'=> 'Activar Usuario'
					));
			}
		} else { 
			echo "<legend class='space'>Cambio de Contraseña</legend>";
			echo $form->input('password', array(
				'label'=>'Contraseña Nueva', 
				'div'=>'input password pull-left ', 
				'size'=>'32', 
				'maxlength'=>'32',
				));
			echo $form->input('passwordConfirm', array(
				'label'=>'Confirmar Contraseña', 
				'type'=>'password', 
				'size'=>'32', 
				'maxlength'=>'32',
				));
		}
		?>
	</fieldset>
<?php echo $html->link('Eliminar', array('action' => 'delete', $this->Form->value('User.id')), array('class'=>'btn btn-form'), sprintf(__('¿Estas seguro que quieres borrar # %s?', true), $this->Form->value('User.name'))); ?>
<?php echo $form->end(array('class'=>'btn btn-primary btn-form', 'label'=>'Guardar'));?>
</div>