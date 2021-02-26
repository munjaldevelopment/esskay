@extends(backpack_view('blank'))

@php
    /*$widgets['before_content'][] = [
        'type'        => 'jumbotron',
        'heading'     => trans('backpack::base.welcome'),
        'content'     => trans('backpack::base.use_sidebar'),
        'button_link' => backpack_url('logout'),
        'button_text' => trans('backpack::base.logout'),
    ];*/
@endphp

@section('content')
	<div class="row">
		<div class="col-md-12 col-12">
			@if($chart1)
				<div id="first_chart"></div>

				{!! $chart1 !!}
			@endif
		</div>
	</div>
	
	<div class="clearfix"></div>
	
	<div class="row padding-top-30">
		<div class="col-md-6 col-12">
			@if($chart2)
				<div id="second_chart"></div>

				{!! $chart2 !!}
			@endif
		</div>
		
		<div class="col-md-6 col-12">
			@if($chart3)
				<div id="third_chart"></div>

				{!! $chart3 !!}
			@endif
		</div>
	</div>
	
	<style>
		.padding-top-30 {
			padding-top:30px;
		}
	</style>
@endsection