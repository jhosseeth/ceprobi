		$('#UserPassword').on('focusout', function(e) {

			if ($('#UserPasswordConfirm').val() != '' && $('#UserPassword').val() == $('#UserPasswordConfirm').val()) {

				$('#message').removeClass('alert-error');
				$('#message').addClass('alert alert-success');
		    	$('#message').html('<img class="flashImg" alt="" src="/img/success.png">Las contraseñas <strong>coinciden</strong>.');
			};			
		});
		$('#UserPasswordConfirm').on('focusin', function(e) {

			if ($('#UserPassword').val() == '') {
				$('#message').addClass('alert alert-error');
				$('#message').html('<img class="flashImg" alt="" src="/img/alert.png">La <strong>contraseña</strong> no puede estar vacía.');

			} else {

				$('#message').removeClass('alert alert-error');
				$('#message').html('');
			};			
		});
		$('#UserPasswordConfirm').on('focusout', function(e) {

			if ($('#UserPassword').val() == '') {
				$('#message').addClass('alert alert-error');
				$('#message').html('<img class="flashImg" alt="" src="/img/alert.png">La <strong>contraseña</strong> no puede estar vacía.');

			} else if ($('#UserPasswordConfirm').val() == '') {

				$('#message').addClass('alert alert-error');
				$('#message').html('<img class="flashImg" alt="" src="/img/alert.png">Necesita <strong>confirmar</strong> la contraseña.');

			} else if ($('#UserPassword').val() != $('#UserPasswordConfirm').val()) {

		    	$('#message').addClass('alert alert-error');
		    	$('#message').html('<img class="flashImg" alt="" src="/img/alert.png">Las contraseñas no <strong>coinciden</strong>, verifique que sean las mismas.');

		    } else if ($('#UserPassword').val() == $('#UserPasswordConfirm').val()) {

				$('#message').removeClass('alert-error');
				$('#message').addClass('alert alert-success');
		    	$('#message').html('<img class="flashImg" alt="" src="/img/success.png">Las contraseñas <strong>coinciden</strong>.');
			};
		});