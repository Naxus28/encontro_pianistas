$(document).foundation();

$(function(){
	/******************AJAX CALL TO EMAIL.PHP********************/
	$('form.ajax').on('submit', function(){
	    var that = $(this),
	        url = that.attr('action'), //get url for ajax call
	        type = that.attr('method'), //get method for ajax call
	        data = {} //initialize data object to store ajax response


	    //find all input fields that have the name attribute
	    that.find('[name]').each(function(){ 
	        var that = $(this),
	            name = that.attr('name'), //get the name attribute value
	            value = that.val(); //get the input value
	            data[name] = value; //build the data obj i.e. {'name' : 'Gabriel', 'email' : 'gabriel@gabriel.com', 'subject' : 'hello'};
	    });

	    //make the ajax call
	    $.ajax({
	        url: url, //call url
	        type: type, //send form method
	        data: data, //send data object
	        success: function(response){
	            var obj = $.parseJSON(response); //parse JSON sent by PHP script -- using json_encode on the PHP script
	            console.log(obj);

	            //check if e-mail was sent and show success alert
	            if(obj['success'] == true){

	                //animate alert div to display on HTML
	                $('div.success').css('display', 'block').animate({opacity: 1}, 500);
	                
	                //append visitor name to the alert
	                $('<span>'+obj['name']+'</span>').insertAfter('span.add_name_after');

	                //hide the fail alert--in case user missed a field in a previous form submission
	                $('div.fail').css('display', 'none');

	                //empty input fields, except the send button
	                $('form.ajax').find('[name]').each(function(){
	                    if($(this).val() != 'Send'){
	                        $(this).val('');
	                    }
	                });

	            }

	            //if form validation fails on email.php
	            else if(obj['success'] == false){

	                //animate alert div to display on HTML
	                $('div.fail').css('display', 'block').animate({opacity: 1}, 500);

	                //append visitor name to the alert
	                $('<span>'+obj['name']+'</span>').insertAfter('span.fill_out_form');
	            }

	            //if e-mail is not sent for any other reason and obj['success'] is not set
	            else {
	                $('<div data-alert class="failed_email alert-box alert radius">I am sorry. There was an error and this e-mail could not be sent. Please contact me at <a class="contact_me" href="mailto:gabrielferraz27@gmail.com?Subject=Hello Gabriel!" target="_top">gabrielferraz27@gmail.com</a><a href="#" class="close">&times;</a></div>').insertBefore('form.ajax');
	                $('div.success').css('display', 'none');
	                $('div.fail').css('display', 'none');
	            }
	        }
	    })
	    return false;
	});

	//Alert closes on "X" click

	$('.close').on('click', function(){
	    $(this).parent('.alert').animate({opacity: 0}, 500);
	});


	/******************STELLAR PLUGIN********************/
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