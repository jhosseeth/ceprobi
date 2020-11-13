<?php echo $this->Html->script('jquery.client_validate_classes');?>
<script type="text/javascript">
	$(function() {

		if ($('.error-message').length > 0) {
			$('#UserPassword').val('');
			$('#UserPasswordConfirm').val('');
		};

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

		// Valida que el nombre de usuario no se encuentre registrado
		$('#UserUsername').on('keyup', function() {
			$(this).siblings('img, div').remove();
			$('#usernameValidateImg').remove();
			if ($(this).val().length >= 5) {
				$(this).val($.trim($(this).val()));
				if($(this).val() == '') {
					submitable = false;
					return false;
				}
				var data = $(this).serialize();
				$.ajax({
					data: data,	
					url: baseUrl + '/users/find_username', 
					type: 'post', 
					async: true, 
					complete: function(data) {
						$('#UserUsername').after(data.responseText);
						submitable = true;
						if($('#usernameValidateImg').hasClass('username-fail')) {
							submitable = false;
						}
					}
				});
			};				
		});

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
			if (passwordVal == '') { 
				alert('La contraseña no puede estar vacía'); 
				return false;
			} else if (passwordSize < 5) { 
				alert('La contraseña debe tener al menos 5 caracteres'); 
				return false;
			} else if (passwordConfirmVal == '') { 
				alert('Confirme la contraseña'); 
				return false;
			} else if (passwordVal != passwordConfirmVal) { 
				alert('Las contraseñas no coinciden'); 
				return false;
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
		<legend>Registro de Usuario</legend>
		<div id="message"></div>
		<?php
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
		echo $form->input('username', array(
			'label'=>'Usuario', 
			'div'=>'input text pull-left', 
			'maxlength'=>'32',
			));
		echo $form->input('password', array(
			'label'=>'Contraseña', 
			'div'=>'input password pull-left break-line', 
			'size'=>'32', 
			'maxlength'=>'32', 
			'placeholder'=>'••••••••••'
			));
		echo $form->input('passwordConfirm', array(
			'label'=>'Confirmar contraseña', 
			'div'=>'input password pull-left', 
			'type'=>'password', 
			'size'=>'32', 
			'maxlength'=>'32', 
			'placeholder'=>'••••••••••'
			));		
		echo $form->input('adress', array(
			'label'=>'Lugar de Residencia', 
			'div'=>'input text pull-left break-line', 
			'size'=>'40', 
			'maxlength'=>'45', 
			'placeholder'=>'País, Ciudad'
			));
		echo $form->input('education_degree', array(
			'label'=>'Estudios ó formacion academica', 
			'div'=>'input text pull-left', 
			'size'=>'40', 
			'maxlength'=>'255', 
			'placeholder'=>'Título ó Universidad'
			));
		echo $form->input('description', array(
			'label'=>'Descripcion', 
			'div'=>'input textarea break-line', 
			'cols'=>'53', 
			'rows'=>'4', 
			'placeholder'=>'Escribe una breve autobiografía aquí...'
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
			'maxlength'=>'255',));
		echo "<legend class='space'></legend>";
		echo $form->input('role_id', array(
			'label'=>'Rol', 
			'div'=>'input select pull-left', 
			'empty'=>'Seleccione...'));
		echo $form->input('magazine_id', array(
			'label'=>'Revista',  
			'empty'=>'Seleccione...'));
		if ($_SESSION['Auth']['Role']['name'] == 'Administrador') {
			echo $form->input('status', array('type' => 'checkbox', 'div'=>'input checkbox pull-left', 'label' => 'Activar Usuario'));
		} else { echo $form->input('status', array('type' => 'hidden', 'value'=>0));}
		?>
	</fieldset>
<?php echo $form->end(array('class'=>'btn btn-primary space', 'label'=>'Guardar'));?>
</div>