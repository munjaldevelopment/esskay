@include('common.header_body')

<div class="preloader" style="display:none;"><div class="sk-cube-grid"><div class="sk-cube sk-cube1"></div><div class="sk-cube sk-cube2"></div><div class="sk-cube sk-cube3"></div><div class="sk-cube sk-cube4"></div><div class="sk-cube sk-cube5"></div><div class="sk-cube sk-cube6"></div><div class="sk-cube sk-cube7"></div><div class="sk-cube sk-cube8"></div><div class="sk-cube sk-cube9"></div></div></div>

<section class="custom-linear pt-3">

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-1 col-2 logo-bar">
			<!-- <span class="mr-3 rounded-circle heading-jhone"></span> -->
			</div>
			<div class="col-md-11 col-10 table_new">
				<div class="media">
					
					<div class="media-body">

						
								<!-- <h5 class="custome-syle">{{ $lenderData->name }}<span class="inner-inner">({{ $lenderData->code }})</span></h5>
								<button id="lender_banking" class="lender_blankingbtn-1">{{ $lenderData->is_onboard }} </button> -->

								<!-- <ul class="breadcrumb">
									<li><a href="#">CIN: U74999MH2008PLC187872</a></li>
									<li><a href="#">NBFC and HFC</a></li>
									<li><span class="two-wheel">Two Wheeler Finance</span></li>
								</ul> -->
					</div>


						
					
				</div>
			</div>
			<!-- <div class="col-md-5 col-12"></div> -->
			<!-- <div class="col-md-4">
				@if($lenderData->is_onboard == 'Onboarded')
				<div class="text-right">
					<h5 class="mb-0 txt-theme"><i class="fa fa-inr"></i>88.90 Cr</h5>
					<small class="priceadd"><b>AUM (as of 31 Mar, 2020)</b></small>
				</div>
				@endif
			</div> -->
		</div>
		<!-- <div id="panel">
			<div class="text-center heading-tabl">
				<h4>some heading text</h4>
				<p>sub headding text here</p>
			</div>	 
			<div class="panel-inside"> 
		 	@if(count($lenderBankingData)>0)
		 	<table class="table">
			  <thead>
			    <tr>
	    		  <th scope="col" class="theadin_tab">Name</th>
			      <th scope="col" class="theadin_tab">Amount</th>
			      <th scope="col" class="theadin_tab">Outstanding Amount</th>
			    </tr>
			  </thead>
			  <tbody>
			  	@foreach($lenderBankingData as $k => $bdetail)
			    <tr>
			      <td>{!! $bdetail['banking_arrangment_name'] !!}</td>
			      <td>{!! $bdetail['sanction_amount'] !!}</td>
			      <td>{!! $bdetail['outstanding_amount'] !!}</td>
			    </tr>
			   @endforeach
			  </tbody>
			</table>
			@else
				<p>No detail found</p>
			@endif	
		</div>
		 </div>	 -->
		
		<div class="row mb-2">
			<div class="col-md-12">
				<hr />
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<ul class="nav custome-navbread esskay-home nav-tabs nav-pills">
					<li class="nav-item">
						<a class="nav-link home-class active" href="javascript:;">Message from MD / CXOs</a>
					</li>
					<li class="nav-item">
						<a class="nav-link doc-class" href="javascript:;">Documents</a>
					</li>
					<li class="nav-item">
					<a class="nav-link news-class" href="javascript:;">Newsletters</a>
					</li>
					<li class="nav-item">
					<a class="nav-link contact-class" href="javascript:;">Contact Us</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</section>


<section class="bg-white">
	<div class="pt-3 home-content">
		
	</div>
</section>
<script> 
$(document).ready(function(){
  $("#lender_banking").click(function(){
    $("#panel").slideToggle("slow");
    return false;
  });
});
</script>
@include('common.footer_body')
