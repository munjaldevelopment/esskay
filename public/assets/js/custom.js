$(document).ready(function() {
	var base_url = $('base').attr('href');
	
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	
	$('.home-class').bind('click', function() {
		$('.esskay-home li a').removeClass('active');
		$('.home-class').addClass('active');
		
		$.ajax({
			url: base_url+'homepage',
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

	$('.board-class').bind('click', function() {
		$('.esskay-home li a').removeClass('active');
		$('.board-class').addClass('active');
		
		$.ajax({
			url: base_url+'board',
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

	$('.key-manager-class').bind('click', function() {
		$('.esskay-home li a').removeClass('active');
		$('.key-manager-class').addClass('active');
		
		$.ajax({
			url: base_url+'keymanager',
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
		
	$('.doc-class').bind('click', function() {
		$('.esskay-home li a').removeClass('active');
		$('.doc-class').addClass('active');
		
		$.ajax({
			url: base_url+'document',
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

	$('.news-class').bind('click', function() {
		$('.esskay-home li a').removeClass('active');
		$('.news-class').addClass('active');
		
		$.ajax({
			url: base_url+'news',
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

	$('.contact-class').bind('click', function() {
		$('.esskay-home li a').removeClass('active');
		$('.contact-class').addClass('active');
		
		$.ajax({
			url: base_url+'contact_us',
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
	
	$('.graph-class').bind('click', function() {
		$('.esskay-home li a').removeClass('active');
		$('.graph-class').addClass('active');
		
		$.ajax({
			url: base_url+'company_graph',
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
	
	var is_message_md = $('#is_message_md').val();
	var is_document = $('#is_document').val();
	var is_financial_summary = $('#is_financial_summary').val();
	
	if(is_message_md == "1")
	{
		$('.home-class').trigger('click');
	}
	else if(is_message_md == "0" && is_document == "1")
	{
		$('.doc-class').trigger('click');
	}
	else if(is_message_md == "0" && is_document == "0" && is_financial_summary == "1")
	{
		$('.graph-class').trigger('click');
	}
});