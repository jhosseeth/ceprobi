/**
 * 
 * Author Geneller Naranjo.
 */

// TODO Revisar que funcione despues de la linea 77.

$(function() {
	// Mapa de reglas-expresiones a evaluar.
	var rules = {
			String : {
				Rule : /[a-zA-Z0-9_ *]+/i,
				Message : 'El valor debe ser un texto.',
				Type : 'Eval'
			},
			Number : {
				Rule : /[0-9]+/i,
				Message : 'El valor debe ser númerico.',
				Type : 'Eval'
			},
			NotEmpty : {
				Message : 'Este campo no puede estar vacío.',
				Type : 'NotEmpty'
			}
	};
	
	var ruleClasses = {
			'val-notempty' : "NotEmpty",
			'val-text' : "String"
	};

	$('form').submit(function() {
		$('.validate-error').remove();
		var ruleFields = {};
		var validateErrors = new Array();
		var controlNames = new Array();
		var controlIds = new Array();
		
		var validated , validateField = true;

		var serializedData = $(this).serializeArray();
		delete serializedData[0];

		$.each(serializedData, function() {
			if ($(this).attr('name') != '') {
				var controlName = $(this).attr('name');
				var value = $.trim($("input[name='" + controlName + "']").val());

				$.each(ruleFields[controlName], function(index) {

					if(rules[this].Type != 'undefined') {

						if((rules[this].Type == 'NotEmpty') && (value == '')) {
							validated = false;
							if (typeof(validateErrors[controlName]) == 'undefined') {
								validateErrors[controlName] = new Array(rules[this].Message);
							} else {
								validateErrors[controlName].push(rules[this].Message);
							}
						}

						if(rules[this].Type == 'Eval') {
							if(!value.match(rules[this].Rule)) {
								validated = false;
								if (typeof(validateErrors[controlName]) == 'undefined') {
									validateErrors[controlName] = new Array(rules[this].Message);
								} else {
									validateErrors[controlName].push(rules[this].Message);
								}
							}
						}
					} else {
					}
				});
			}
		});

		var classDivs = $('.validate');
		var errors = '';
		
		$.each(classDivs, function() {
			validateField = true;
			var thisDiv = $(this);
			var input = $(this).children('input');
			var value = input.val();
			var controlName = input.attr('name');
			var controlId = input.attr('id');
			
			if(!validateField) {
				controlNames.push(controlName);
				controlIds[controlName] = controlId;
			}
		});
		
		$.each(controlNames, function(index, thisControlName) {
			
			var errorMessage = '';

			// Recorre los errores por control.
			$.each(validateErrors[thisControlName], function() {
				
				// Convierte el objeto a string.
				$.each(this, function() {
					errorMessage += this;
				});
			});
			
			// Html con el error.
			errorMessage = '<img class="validate-error" src="../img/warning-validate.png" title="' + errorMessage + '">';
			$('input[id=' + controlIds[thisControlName] + ']').after(errorMessage);
		});

		// Retorna el valor de la validación.
		return validated;
	});
});