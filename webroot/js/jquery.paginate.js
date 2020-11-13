/**
 *
 * @author Geneller Naranjo.
 * @version 1.0.
 */
// Keys that should not trigger search.
var unavailableKeyCodes = [ 9, 13, 16, 17, 18, 19, 20, 27, 35, 36, 37, 38, 39,
		40, 45, 93, 106, 107, 109, 110, 111, 112, 113, 114, 115, 116, 117, 118,
		119, 120, 121, 122, 123, 144, 145, 186, 187, 189, 190, 191, 192, 219,
		220, 221, 222 ];

(function(jQuery) {

	jQuery.fn.paginate = function(options) {
		var defaults = {
			ajaxDelay : 8,
			timerUpdate : 0,
			timer : 0,
			urlRequest : '',
			formId : '',
			tagToUpdateId : '',
			fromReplaceUrl : '',
			toReplaceUrl : '',
			requesting : true,
			complete : function() {
			},
			completeTimer : function() {
			},
			// Avoid first request when creating the ajax object.
			request : ''
		};

		var _this = this;
		var opts = jQuery.extend(defaults, options);

		opts.paginate = function() {

			if (opts.requesting == true && typeof (opts.request) == 'object') {
				request.abort();
			}

			var data = $('#' + opts.formId).serialize();
			request = $.ajax({
				type : 'post',
				async : true,
				url : opts.urlRequest,
				data : data,
				beforeSend : function() {
					opts.requesting = true;
				},
				complete : function(data) {
					$('#' + opts.tagToUpdateId).html(data.responseText);
					opts.requesting = false;
					opts.complete();
				}
			});
		};

		$('#' + opts.formId + ' div input').keyup(function(e) {
			opts.ajaxDelay = 1;
		});

		$('#' + opts.formId + ' div select').change(function(e) {
			opts.ajaxDelay = 1;
		});

		$('#' + opts.formId + ' div input:checkbox').change(function(e) {
			opts.ajaxDelay = 1;
		});

		$('#' + opts.formId).submit(function() {
			return false;
		});

		$('#' + opts.tagToUpdateId + ' .paging a').live(
				'click',
				function(e) {
					e.preventDefault();
					var href = $(this).attr('href');
					opts.urlRequest = href.replace(opts.fromReplaceUrl,
							opts.toReplaceUrl);
					opts.ajaxDelay = 7;
				});

		$('#' + opts.tagToUpdateId + ' table th a').live(
				'click',
				function(e) {
					e.preventDefault();
					var href = $(this).attr('href');
					opts.urlRequest = href.replace(opts.fromReplaceUrl,
							opts.toReplaceUrl);
					opts.ajaxDelay = 7;
					
				});

		setInterval(function() {
			opts.ajaxDelay++;
			if (opts.ajaxDelay == 8) {
				opts.paginate();
			}
		}, 100);

		// Timer for cyclic refresh.
		if(opts.timerUpdate != 0) {
			setInterval(function() {
				opts.timer++;
				if (opts.timer == opts.timerUpdate) {
					opts.paginate();
					opts.timer = 0;
				}
				opts.completeTimer();
			}, 1000);
		}
	};
})(jQuery);