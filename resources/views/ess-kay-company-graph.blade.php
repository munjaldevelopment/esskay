<div class="outer-bg">
	<div class="container-fluid inner-bg">
		<div class="row">
			<div class="col-md-12 col-12">
				<div class="row">
					<div class="col-md-6 col-12">
						<h1 class="top-left-margin">{{ $heading_title }}</h1>
					</div>
				</div>
			
				<div class="row">
					<div class="col-md-6 col-12">
						@if($chart1)
							<div id="first_chart"></div>

							{!! $chart1 !!}
							
							{!! $remarks1 !!}
						@endif
					</div>
					
					<div class="col-md-6 col-12">
						@if($chart2)
							<div id="second_chart"></div>

							{!! $chart2 !!}
							
							{!! $remarks2 !!}
						@endif
					</div>
				</div>
				
				<div class="clearfix"></div>
				
				<div class="row">
					<div class="col-md-6 col-12">
						@if($chart3)
							<div id="third_chart"></div>

							{!! $chart3 !!}
							
							{!! $remarks3 !!}
						@endif
					</div>
					
					<div class="col-md-6 col-12">
						@if($chart4)
							<div id="fourth_chart"></div>

							{!! $chart4 !!}
							
							{!! $remarks4 !!}
						@endif
					</div>
				</div>   
				
				<div class="clearfix"></div>
				
				{{--<div class="row">
					<div class="col-md-6 col-12">
						@if($chart5)
							<div id="fifth_chart"></div>

							{!! $chart5 !!}
							
							{!! $remarks5 !!}
						@endif
					</div>
				</div>
				
				<div class="clearfix"></div>--}}
				
				<div class="row">
					<div class="col-md-6 col-12">               
						{!! $graph_content !!}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Google Web Fonts -->
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
<style>
	h1.top-left-margin {
		padding-left: 25px;
		padding-top: 15px;
		font-size: 30px;
		padding-bottom: 25px;
	}
</style>