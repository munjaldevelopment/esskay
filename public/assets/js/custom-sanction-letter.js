$(document).ready(function() {
	var base_url = $('base').attr('href');
	
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	
	$('.sanction-letter-class').bind('click', function() {
		$('.esskay-sanction-letter li a').removeClass('active');
		$('.esskay-sanction-letter li button').removeClass('active');
		$('.sanction-letter-class').addClass('active');

		$('.sanction-letter-container').removeClass('show');

		$('#collapsibleNavbar').removeClass('show');
		
		$.ajax({
			url: base_url+'sanctionletter',
			type: 'post',
			data: {_token: CSRF_TOKEN},
			beforeSend: function() {
				$('.preloader').show();
			},
			success: function(output) {
				$('.preloader').hide();
				$('.sanction-letter-container').removeClass('show');
				$('.home-content').html(output);
			}
		});
	});

	$('.contact-class').bind('click', function() {
		$('.esskay-home li a').removeClass('active');
		$('.esskay-home li button').removeClass('active');
		$('.contact-class').addClass('active');

		$('#collapsibleNavbar').removeClass('show');
		
		$.ajax({
			url: base_url+'contact_us_sanctionletter',
			type: 'post',
			data: {_token: CSRF_TOKEN},
			beforeSend: function() {
				$('.preloader').show();
			},
			success: function(output) {
				$('.preloader').hide();
				$('.home-content').html(output);
			}
		});
	});

	$('.sanction-letter-class').trigger('click');
});