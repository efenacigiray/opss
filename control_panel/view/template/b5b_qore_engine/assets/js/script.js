/* Get URL Parameters */
var getUrlParameter = function getUrlParameter(sParam) {
	var sPageURL = decodeURIComponent(window.location.search.substring(1)),
	sURLVariables = sPageURL.split('&'),
	sParameterName,
	i;

	for (i = 0; i < sURLVariables.length; i++) {
		sParameterName = sURLVariables[i].split('=');

		if (sParameterName[0] === sParam) {
			return sParameterName[1] === undefined ? true : sParameterName[1];
		}
	}
};

// Token
var userToken = getUrlParameter('user_token');

$(document).ready(function(){

	if($('.promo-slider').length){
		$('.promo-slider').unslider();

		var sliderCount = $('.promo-slider > .unslider-wrap li').length;

		if(sliderCount > 1){
			$('.unslider-nav, .unslider-arrow').show();
		}
	}

	$('a.enable-theme').on('click', function(e) {
		e.preventDefault();

		var thisButton = $(this);

		thisButton.button('loading');

		var themeName = encodeURIComponent(thisButton.closest('.profile_details').data('theme-name'));

		$.ajax({
			type: 'get',
			url: 'index.php?route=extension/module/b5b_qore_engine/enableTheme&user_token=' + encodeURIComponent(userToken) + '&theme_name=' + themeName,
			dataType: 'json',
			success: function(json) {
				if(json.success){
					location.reload();
				}else{
					thisButton.button('reset');
					thisButton.closest('.bottom').before('<div class="col-xs-12"><div role="alert" class="alert alert-danger alert-dismissible fade in"><button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>' + json.error_message + '</div></div>');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				$(this).button('reset');
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	});

	$('#button-setting').on('click', function() {
		$.ajax({
			url: 'index.php?route=common/developer&user_token=' + userToken,
			dataType: 'html',
			beforeSend: function() {
				$('#button-setting').button('loading');
			},
			complete: function() {
				$('#button-setting').button('reset');
			},
			success: function(html) {
				$('#modal-developer').remove();

				$('body').prepend('<div id="modal-developer" class="modal">' + html + '</div>');

				$('#modal-developer').modal('show');
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});	
	});	
});