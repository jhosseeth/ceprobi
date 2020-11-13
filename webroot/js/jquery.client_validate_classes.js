/**
 *
 * @author Geneller Naranjo.
 * @version 2.0.
 */
$(function() {

    var ruleClasses = [
            {CssC: 'v-number', Message: 'Valor Numerico invalido'            , Rule:	/^[0-9]+$/ },
            {CssC: 'v-negnumber', Message: 'Valor Numerico invalido'            , Rule:	/^\-?[0-9]+$/},
            {CssC: 'v-decimal', Message: 'Valor Decimal invalido'            	, Rule:	/^\-?[0-9]*\.?[0-9]+$/},
            {CssC: 'v-email', Message: 'Formato de correo invalido'         , Rule:	/^[a-zA-Z0-9.!#$%&amp;'*+\-\/=?\^_`{|}~\-]+@[a-zA-Z0-9\-]+(?:\.[a-zA-Z0-9\-]+)*$/},
            {CssC: 'v-text', Message: 'Formato de texto invalido'          , Rule:	/^[a-zñ]+/i},
            {CssC: 'v-text-space', Message: 'Formato de texto invalido'          , Rule:	/^[a-z ñ]+$/i},
            {CssC: 'v-alphanum', Message: 'Formato de texto/Numerico invalido'	, Rule:	/^[a-z0-9ñ]+$/i},
            {CssC: 'v-alphanum-', Message: 'Formato de texto invalido'          , Rule:	/^[a-z0-9_\-]+$/i},
            {CssC: 'v-numeric', Message: 'Valor Numerico invalido'            , Rule:	/^[0-9 -]+$/i},
            {CssC: 'v-startnum', Message: 'Valor Numerico invalido'	          , Rule:	/^[1-9][0-9]*$/i},
            {CssC: 'v-ip', Message: 'Formato de IP invalido'          		, Rule:	/^((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){3}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})$/i},
            {CssC: 'v-base64', Message: 'Formato base64 invalido'	          , Rule:	/[^a-zA-Z0-9\/\+=]/i},
            {CssC: 'v-decimal', Message: 'Valor Numerico invalido' 	  	      , Rule:	/^[\d\-\s]+$/},
            {CssC: 'v-url', Message: 'Formato de URL invalido'	        	, Rule:	/^(((http|https):\/\/|w)(\w+:{0,1}\w*@)?(\S+)|)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?$/}
    ];

    $(document).on('submit', 'form', function() {

		$('.validate-error').remove();
		var validated , validateField = true;
		var classDivs = $('.validate');

		$.each(classDivs, function() {
			var valErrors = '';
			validateField = true;
			var thisDiv = $(this);
			var input = $(this).children('input');
			var value = input.val();

			if(typeof(value) == 'undefined') {
				input = $(this).children('select');
				value = input.val();
			}
			if(typeof(value) == 'undefined') {
				input = $(this).children('textarea');
				value = input.val();
			}
			if(typeof(input) == 'undefined' || typeof(value) == 'undefined') {
				return true;
			}

			if(input.attr('disabled') == 'disabled') {
				return true;
			}

			value = value.toString();

			if(thisDiv.hasClass('v-required') && value == '') {
				validateField = false;
				valErrors += 'Este campo no puede estar vacío';

			} else {
				$.each(ruleClasses, function() {
					if(thisDiv.hasClass(this.CssC)) {
						if(!this.Rule.test(value) && value != '') {
							validateField = false;
							valErrors += this.Message;
						}
					}
				});
			}

			if(!validateField) {
				errorMessage = '<img class="validateImg" src="' + baseUrl + '/img/error.png" title="' + valErrors + '">';
				$('#' +  input.attr('id')).after(errorMessage);
				validated = false;
			}
		});
		return validated;
    });
});