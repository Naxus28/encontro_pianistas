$(document).foundation();

$(function(){
	$.stellar({
	  horizontalOffset: 0,
	  verticalOffset: 0
	});

	var app = {
		openCloseMenu : function(translate) {
			translate = typeof(translate) != 'undefined' ? $('aside').css({'transform':'translate(0, 0)'}) : $('aside').css({'transform':'translate(100%, 0)'});
		}
	}

	/*=======CLICK EVENTS AND EVENT LISTENERS=======*/
	$('.open_menu').on('click',(function() {
		app.openCloseMenu(true);
	}));
	$('.close_menu').on('click',(function() {
		app.openCloseMenu();
	}));

	$('.open_videos').each(function(){
		$(this).on('click', function(){
			// alert('works');
			$(this).closest('.row').siblings('.show_videos').slideToggle('slow');
		});
		;
	});
});