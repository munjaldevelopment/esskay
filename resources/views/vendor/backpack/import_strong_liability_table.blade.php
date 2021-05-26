@extends(backpack_view('blank'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
    
    trans('Strong Liability Table') => false,
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
<div class="container-fluid">
    <h2>
      <span class="text-capitalize">Import Strong Liability Table Sheet</span>
	  <small id="datatable_info_stack"></small>
	</h2>
</div>
@endsection

@section('content')
<div class="row"> 
	<!-- THE ACTUAL CONTENT -->
	<div class="col-md-12">
		@if ($message = Session::get('success'))
		<div class="alert alert-success" role="alert"> {!! Session::get('success') !!} </div>
		@endif
		
		
		@if ($message = Session::get('error'))
		<div class="alert alert-danger" role="alert"> {!! Session::get('error') !!} </div>
		@endif
		<form action="{{ URL(config('backpack.base.route_prefix'), 'insertStrongLiabilityTable') }}" method="post" enctype="multipart/form-data">
			{!! csrf_field() !!}
		  	<div class="col-md-12">

		    	<div class="row display-flex-wrap">
			
					<div class="box col-md-12 padding-10 p-t-20"> 
						<!-- load the view from type and view_namespace attribute if set --> 
						
						<!-- text input -->
						<div class="form-group col-xs-12">
							<label>Choose File</label>
							<input type="file" name="strong_liability_table_file" class="form-control" />
						</div>
					</div>
				</div>
				
				<div class="">
					<div id="saveActions" class="form-group">
						<div class="btn-group">
							<button type="submit" class="btn btn-success"><i class="fa fa-cloud"></i> Import Excel File</button>
							&nbsp;&nbsp; </div>
						<a href="{{ URL::to('esskayadmin/strongliabilityprofiletable') }}" class="btn btn-default"><span class="fa fa-ban"></span> &nbsp;Cancel</a> </div>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection