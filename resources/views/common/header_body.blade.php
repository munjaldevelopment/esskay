<!DOCTYPE html>
<html lang="en">
<head>
	<title> {{ $title }}</title>
	<meta charset="utf-8">

	<base href="{{ asset('/') }}" />
	
	<meta name="description" content="{{ $meta_description }}" />
	<meta name="keywords" content="{{ $meta_keywords }}" />

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=0" />
	<link rel="stylesheet" type="text/css" href="{{ asset('public/assets/') }}/css/style.css">
	<link rel="stylesheet" href="{{ asset('public/assets/') }}/css/bootstrap.min.css">
	<link rel="stylesheet" href="{{ asset('public/assets/') }}/css/swiper.min.css">
	<link rel="stylesheet" href="{{ asset('public/assets/') }}/css/esskay-swiper.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{ asset('public/assets/') }}/css/jquery.mCustomScrollbar.css">
	<link rel="stylesheet" href="{{ asset('public/assets/') }}/css/owl.carousel.min.css">	
	<link rel="stylesheet" href="{{ asset('public/assets/') }}/css/custom-style.css">
	
	<!--font family placed by ranveer -->
	<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="{{ asset('public/assets/') }}/js/jquery.min.js"></script>
	<script src="{{ asset('public/assets/') }}/js/bootstrap.min.js"></script>
	<script src="{{ asset('public/assets/') }}/js/swiper.jquery.js"></script>
	<script src="{{ asset('public/assets/') }}/js/custom.js"></script>
	
	<script src="{{ asset('public/assets/') }}/js/sweetalert.min.js"></script>
	
	<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
	<!-- header start here -->

	<header>
		<nav class="navbar navbar-expand-md">
			<a class="navbar-brand" href="{{ asset('/') }}"><img src="{{ asset('public/') }}/{{ site_logo }}"></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
				<span class=""><i class="fa fa-bars"></i></span>
			</button>
			<div class="collapse navbar-collapse" id="collapsibleNavbar">
				<ul class="navbar-nav ml-auto nav-custome d-sm-none">
					@if($lenderData->is_message_md == 1)
					<li class="nav-item">
						<!-- Single button -->
						<div class="dropdown dropdown-lender">
							<button type="button" class="active btn-menu nav-link btn btn-primary about-class dropdown-toggle" data-toggle="dropdown">About Us</button>
						  	<div class="dropdown-menu about-container">
								<a class="dropdown-item home-class" href="javascript:;">Message from MD</a>
								<a class="dropdown-item board-class" href="javascript:;">Board of  Directors</a>
								<a class="dropdown-item key-manager-class" href="javascript:;">Key Managerial Person</a>
						  	</div>
						</div>
					</li>

					@endif
					@if($lenderData->is_insight == 1)
					<li class="nav-item">
						<a class="nav-link insight-class @if($lenderData->is_message_md == 0) active @endif" href="javascript:;">Insights</a>
					</li>
					@endif
					@if($lenderData->is_document == 1)
					<li class="nav-item">
						<a class="nav-link doc-class @if($lenderData->is_message_md == 0 && $lenderData->is_insight == 0) active @endif" href="javascript:;">Document</a>
					</li>
					@endif
					@if($lenderData->is_sanction_letter == 1)
					<li class="nav-item">
						<a class="nav-link sanction-letter-class @if($lenderData->is_message_md == 0) active @endif" href="javascript:;">Sanction Letter</a>
					</li>
					@endif
					@if($lenderData->is_current_deal  == 1)
					<li class="nav-item">
					<a class="nav-link deal-class @if($lenderData->is_message_md == 0 && $lenderData->is_insight == 0 && $lenderData->is_document == 0) active @endif" href="javascript:;">Current Deal</a>
					</li>
					@endif

					@if($lenderData->is_financial_summary == 1)
					<!--<li class="nav-item">
					<a class="nav-link graph-class @if($lenderData->is_message_md == 0 && $lenderData->is_document == 0) active @endif" href="javascript:;">Financial Summary</a>
					</li>-->
					@endif
					@if($lenderData->is_newsletter == 1)
					<li class="nav-item">
					<a class="nav-link news-class @if($lenderData->is_message_md == 0 && $lenderData->is_insight == 0 && $lenderData->is_document == 0 && $lenderData->is_financial_summary == 0) active @endif" href="javascript:;">Newsletters</a>
					</li>
					@endif
					@if($lenderData->is_contact_us == 1)
					<li class="nav-item">
					<a class="nav-link contact-class @if($lenderData->is_message_md == 0 && $lenderData->is_insight == 0 && $lenderData->is_document == 0 && $lenderData->is_financial_summary == 0 && $lenderData->is_newsletter == 0) active @endif" href="javascript:;">Contact Us</a>
					</li>
					@endif

					<li class="nav-item">
						<a class="nav-link" href="{{ asset('/edit-password') }}">Change Password</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ asset('/logout') }}">Logout</a>
					</li>
				</ul>

				<ul class="navbar-nav ml-auto nav-custome d-none d-sm-flex-block">
					@if($customer_name)
					{{--<li class="nav-item">
						<a class="nav-link" href="#">Dashboard</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">transaction</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">client</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">resources</a>
					</li>--}} 


					<li class="operation-li"><h5 class="custome-syle">{{ $lenderData->name }}<span class="inner-inner">({{ substr($lenderData->name, 0, 1) }})</span></h5>
						<div class="onbrd-btn">
							<button id="lender_banking" class="lender_blankingbtn-1">{{ $lenderData->is_onboard }} </button>
						</div> 
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
							<span class="mr-1 rounded-circle heading-jhone">{{ substr($lenderData->name, 0, 1) }}</span>
						</a>
						
						<div class="dropdown-menu dropdown-menu-right">
							{{--<a class="dropdown-item" href="#">My Profile</a>
							<a class="dropdown-item" href="#">Dashboard</a>--}}
							<a class="dropdown-item" href="{{ asset('/edit-password') }}">Change Password</a>
							<a class="dropdown-item" href="{{ asset('/logout') }}">Logout</a>
							</div>
					</li>
					<!-- <li><button id="lender_banking" class="lender_blankingbtn-1">{{ $lenderData->is_onboard }} </button> </li>  -->
					@endif
				</ul>

			</div> 

		</nav>
	</header>