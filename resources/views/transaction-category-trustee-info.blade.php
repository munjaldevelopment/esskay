<div class="mtd-breadcrumb">		   
	<ul class="breadcrumb">
	  <li><a href="#">{{ $categoryData->category_name }}</a></li>
	  <li>{{ $transactionData->name }}</li>
	</ul>
</div>

<div class="mtb-inner-category">
	<div class="owl-carousel mtb_category_scroller">
		<div class="item active">
		  <a class="btn-report-type" data-val="1" href="javascript:;">Executed Report</a>
		</div>
		<div class="item">
		  <a class="btn-report-type" data-val="2" href="javascript:;">Monthly Payout Report</a>
		</div>
		<div class="item">
		  <a class="btn-report-type" data-val="3" href="javascript:;">Collection efficiency</a>
		</div>
		<div class="item">
		  <a class="btn-report-type" data-val="4" href="javascript:;">Pool Dynamics</a>
		</div>
	  </div>
</div>

<div class="mtd-timeline">
	<ul>
		@foreach($document_date as $k => $row)
		<li @if($k == $docu_date) class="active" @endif><a href="javascript:;" class="btn-child-date" data-date="{{ $row }}">{{ $row}}</a></li>
		@endforeach
	</ul>
</div>

<div class="mtd-timeline-content">
	<div class="border-title">	
		<span>Lorem Ipsum is Dummy Text</span>
	</div>

	<div class="mtd-accordian">
		 <div id="accordion">
			  <div class="card">
				<div class="card-header">
					<a class="card-link" data-toggle="collapse" href="#execuled_doc_1" aria-expanded="true">
						Term Sheet
						<span class="collapsed accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
						<span class="expanded accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
					</a>
				</div>
				<div id="execuled_doc_1" class="collapse show" data-parent="#accordion" >
				  <div class="card-body">
						<div class="mtd-timline-document">
							<div class="row">
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>Capital Adequacy Statement </h4>	
											<p>September 30, 2020</p>													
										</div>
										<div class="mtdd-doc-check"><img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt=""></div>
										<div class="mtd-doc-hover">
											<ul>
												<li><a href=""><i class="fa fa-refresh" aria-hidden="true"></i></a></li>
												<li><a href=""><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>Banking Arrangement </h4>	
											<p>October 30, 2020</p>													
										</div>
										<div class="mtdd-doc-check"><img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt=""></div>
										<div class="mtd-doc-hover">
											<ul>
												<li><a href=""><i class="fa fa-refresh" aria-hidden="true"></i></a></li>
												<li><a href=""><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>															
							</div>
							<div class="row">															
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>Banking Arrangement </h4>	
											<p>October 30, 2020</p>													
										</div>
										<div class="mtdd-doc-check"><img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt=""></div>
										<div class="mtd-doc-hover">
											<ul>
												<li><a href=""><i class="fa fa-refresh" aria-hidden="true"></i></a></li>
												<li><a href=""><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>	
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>Capital Adequacy Statement </h4>	
											<p>September 30, 2020</p>													
										</div>
										<div class="mtdd-doc-check"><img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt=""></div>
										<div class="mtd-doc-hover">
											<ul>
												<li><a href=""><i class="fa fa-refresh" aria-hidden="true"></i></a></li>
												<li><a href=""><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
				  </div>
				</div>
			  </div>

			  <div class="card">
				<div class="card-header">
					<a class="card-link collapsed" data-toggle="collapse" href="#execuled_doc_2" aria-expanded="false">
						Service Agreement
						<span class="collapsed accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
						<span class="expanded accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
					</a>
				</div>
				<div id="execuled_doc_2" class="panel-collapse collapse" data-parent="#accordion">
				  <div class="card-body">
						<div class="mtd-timline-document">
							<div class="row">
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>Capital Adequacy Statement </h4>	
											<p>September 30, 2020</p>													
										</div>
										<div class="mtdd-doc-check"><img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt=""></div>
										<div class="mtd-doc-hover">
											<ul>
												<li><a href=""><i class="fa fa-refresh" aria-hidden="true"></i></a></li>
												<li><a href=""><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>Banking Arrangement </h4>	
											<p>October 30, 2020</p>													
										</div>
										<div class="mtdd-doc-check"><img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt=""></div>
										<div class="mtd-doc-hover">
											<ul>
												<li><a href=""><i class="fa fa-refresh" aria-hidden="true"></i></a></li>
												<li><a href=""><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>															
							</div>
							<div class="row">															
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>Banking Arrangement </h4>	
											<p>October 30, 2020</p>													
										</div>
										<div class="mtdd-doc-check"><img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt=""></div>
										<div class="mtd-doc-hover">
											<ul>
												<li><a href=""><i class="fa fa-refresh" aria-hidden="true"></i></a></li>
												<li><a href=""><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>	
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>Capital Adequacy Statement </h4>	
											<p>September 30, 2020</p>													
										</div>
										<div class="mtdd-doc-check"><img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt=""></div>
										<div class="mtd-doc-hover">
											<ul>
												<li><a href=""><i class="fa fa-refresh" aria-hidden="true"></i></a></li>
												<li><a href=""><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
				  </div>
				</div>
			  </div>		

			  <div class="card">
				<div class="card-header">
					<a class="card-link collapsed" data-toggle="collapse"  href="#execuled_doc_3" aria-expanded="false">
						Account Agreement
						<span class="collapsed accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
						<span class="expanded accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
					</a>
				</div>
				<div id="execuled_doc_3" class="panel-collapse collapse" data-parent="#accordion">
				  <div class="card-body">
						<div class="mtd-timline-document">
							<div class="row">
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>Capital Adequacy Statement </h4>	
											<p>September 30, 2020</p>													
										</div>
										<div class="mtdd-doc-check"><img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt=""></div>
										<div class="mtd-doc-hover">
											<ul>
												<li><a href=""><i class="fa fa-refresh" aria-hidden="true"></i></a></li>
												<li><a href=""><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>Banking Arrangement </h4>	
											<p>October 30, 2020</p>													
										</div>
										<div class="mtdd-doc-check"><img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt=""></div>
										<div class="mtd-doc-hover">
											<ul>
												<li><a href=""><i class="fa fa-refresh" aria-hidden="true"></i></a></li>
												<li><a href=""><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>															
							</div>
							<div class="row">															
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>Banking Arrangement </h4>	
											<p>October 30, 2020</p>													
										</div>
										<div class="mtdd-doc-check"><img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt=""></div>
										<div class="mtd-doc-hover">
											<ul>
												<li><a href=""><i class="fa fa-refresh" aria-hidden="true"></i></a></li>
												<li><a href=""><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>	
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>Capital Adequacy Statement </h4>	
											<p>September 30, 2020</p>													
										</div>
										<div class="mtdd-doc-check"><img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt=""></div>
										<div class="mtd-doc-hover">
											<ul>
												<li><a href=""><i class="fa fa-refresh" aria-hidden="true"></i></a></li>
												<li><a href=""><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
				  </div>
				</div>
			  </div>

			  <div class="card">
				<div class="card-header">
					<a class="card-link collapsed" data-toggle="collapse"  href="#execuled_doc_4" aria-expanded="false">
						Assignment Agreement
						<span class="collapsed accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
						<span class="expanded accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
					</a>
				</div>
				<div id="execuled_doc_4" class="panel-collapse collapse" data-parent="#accordion">
				  <div class="card-body">
						<div class="mtd-timline-document">
							<div class="row">
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>Capital Adequacy Statement </h4>	
											<p>September 30, 2020</p>													
										</div>
										<div class="mtdd-doc-check"><img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt=""></div>
										<div class="mtd-doc-hover">
											<ul>
												<li><a href=""><i class="fa fa-refresh" aria-hidden="true"></i></a></li>
												<li><a href=""><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>Banking Arrangement </h4>	
											<p>October 30, 2020</p>													
										</div>
										<div class="mtdd-doc-check"><img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt=""></div>
										<div class="mtd-doc-hover">
											<ul>
												<li><a href=""><i class="fa fa-refresh" aria-hidden="true"></i></a></li>
												<li><a href=""><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>															
							</div>
							<div class="row">															
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>Banking Arrangement </h4>	
											<p>October 30, 2020</p>													
										</div>
										<div class="mtdd-doc-check"><img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt=""></div>
										<div class="mtd-doc-hover">
											<ul>
												<li><a href=""><i class="fa fa-refresh" aria-hidden="true"></i></a></li>
												<li><a href=""><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>	
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>Capital Adequacy Statement </h4>	
											<p>September 30, 2020</p>													
										</div>
										<div class="mtdd-doc-check"><img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt=""></div>
										<div class="mtd-doc-hover">
											<ul>
												<li><a href=""><i class="fa fa-refresh" aria-hidden="true"></i></a></li>
												<li><a href=""><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
				  </div>
				</div>
			  </div>

			  <div class="card">
				<div class="card-header">
					<a class="card-link collapsed" data-toggle="collapse"  href="#execuled_doc_5" aria-expanded="false">
						Trusr Deed
						<span class="collapsed accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
						<span class="expanded accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
					</a>
				</div>
				<div id="execuled_doc_5" class="panel-collapse collapse" data-parent="#accordion">
				  <div class="card-body">
						<div class="mtd-timline-document">
							<div class="row">
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>Capital Adequacy Statement </h4>	
											<p>September 30, 2020</p>													
										</div>
										<div class="mtdd-doc-check"><img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt=""></div>
										<div class="mtd-doc-hover">
											<ul>
												<li><a href=""><i class="fa fa-refresh" aria-hidden="true"></i></a></li>
												<li><a href=""><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>Banking Arrangement </h4>	
											<p>October 30, 2020</p>													
										</div>
										<div class="mtdd-doc-check"><img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt=""></div>
										<div class="mtd-doc-hover">
											<ul>
												<li><a href=""><i class="fa fa-refresh" aria-hidden="true"></i></a></li>
												<li><a href=""><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>															
							</div>
							<div class="row">															
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>Banking Arrangement </h4>	
											<p>October 30, 2020</p>													
										</div>
										<div class="mtdd-doc-check"><img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt=""></div>
										<div class="mtd-doc-hover">
											<ul>
												<li><a href=""><i class="fa fa-refresh" aria-hidden="true"></i></a></li>
												<li><a href=""><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>	
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>Capital Adequacy Statement </h4>	
											<p>September 30, 2020</p>													
										</div>
										<div class="mtdd-doc-check"><img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt=""></div>
										<div class="mtd-doc-hover">
											<ul>
												<li><a href=""><i class="fa fa-refresh" aria-hidden="true"></i></a></li>
												<li><a href=""><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
				  </div>
				</div>
			  </div>

			  <div class="card">
				<div class="card-header">
					<a class="card-link collapsed" data-toggle="collapse"  href="#execuled_doc_6" aria-expanded="false">
						I/M
						<span class="collapsed accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
						<span class="expanded accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
					</a>
				</div>
				<div id="execuled_doc_6" class="panel-collapse collapse" data-parent="#accordion">
				  <div class="card-body">
						<div class="mtd-timline-document">
							<div class="row">
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>Capital Adequacy Statement </h4>	
											<p>September 30, 2020</p>													
										</div>
										<div class="mtdd-doc-check"><img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt=""></div>
										<div class="mtd-doc-hover">
											<ul>
												<li><a href=""><i class="fa fa-refresh" aria-hidden="true"></i></a></li>
												<li><a href=""><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>Banking Arrangement </h4>	
											<p>October 30, 2020</p>													
										</div>
										<div class="mtdd-doc-check"><img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt=""></div>
										<div class="mtd-doc-hover">
											<ul>
												<li><a href=""><i class="fa fa-refresh" aria-hidden="true"></i></a></li>
												<li><a href=""><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>															
							</div>
							<div class="row">															
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>Banking Arrangement </h4>	
											<p>October 30, 2020</p>													
										</div>
										<div class="mtdd-doc-check"><img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt=""></div>
										<div class="mtd-doc-hover">
											<ul>
												<li><a href=""><i class="fa fa-refresh" aria-hidden="true"></i></a></li>
												<li><a href=""><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>	
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>Capital Adequacy Statement </h4>	
											<p>September 30, 2020</p>													
										</div>
										<div class="mtdd-doc-check"><img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt=""></div>
										<div class="mtd-doc-hover">
											<ul>
												<li><a href=""><i class="fa fa-refresh" aria-hidden="true"></i></a></li>
												<li><a href=""><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
				  </div>
				</div>
			  </div>

			  <div class="card">
				<div class="card-header">
					<a class="card-link collapsed" data-toggle="collapse"  href="#execuled_doc_7" aria-expanded="false">
						Any Other Document
						<span class="collapsed accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
						<span class="expanded accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
					</a>
				</div>
				<div id="execuled_doc_7" class="panel-collapse collapse" data-parent="#accordion">
				  <div class="card-body">
						<div class="mtd-timline-document">
							<div class="row">
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>Capital Adequacy Statement </h4>	
											<p>September 30, 2020</p>													
										</div>
										<div class="mtdd-doc-check"><img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt=""></div>
										<div class="mtd-doc-hover">
											<ul>
												<li><a href=""><i class="fa fa-refresh" aria-hidden="true"></i></a></li>
												<li><a href=""><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>Banking Arrangement </h4>	
											<p>October 30, 2020</p>													
										</div>
										<div class="mtdd-doc-check"><img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt=""></div>
										<div class="mtd-doc-hover">
											<ul>
												<li><a href=""><i class="fa fa-refresh" aria-hidden="true"></i></a></li>
												<li><a href=""><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>															
							</div>
							<div class="row">															
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>Banking Arrangement </h4>	
											<p>October 30, 2020</p>													
										</div>
										<div class="mtdd-doc-check"><img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt=""></div>
										<div class="mtd-doc-hover">
											<ul>
												<li><a href=""><i class="fa fa-refresh" aria-hidden="true"></i></a></li>
												<li><a href=""><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>	
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>Capital Adequacy Statement </h4>	
											<p>September 30, 2020</p>													
										</div>
										<div class="mtdd-doc-check"><img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt=""></div>
										<div class="mtd-doc-hover">
											<ul>
												<li><a href=""><i class="fa fa-refresh" aria-hidden="true"></i></a></li>
												<li><a href=""><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
				  </div>
				</div>
			  </div>
		</div>	
	</div>

</div>

<script src="{{ asset('public/assets/') }}/js/jquery.mCustomScrollbar.concat.min.js"></script>	
<script src="{{ asset('public/assets/') }}/js/owl.carousel.js"></script>

<script>

$(document).ready(function() {
	
	var base_url = $('base').attr('href');
	
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

	$('.navbar-toggle').click(function () {
        $('.navbar-nav').toggleClass('slide-in');
        $('.side-body').toggleClass('body-slide-in');
        $('#search').removeClass('in').addClass('collapse').slideUp(200);

        /// uncomment code for absolute positioning tweek see top comment in css
        //$('.absolute-wrapper').toggleClass('slide-in');
        
    });

    (function($){
		$(window).on("load",function(){
			$("#content-1").mCustomScrollbar({
				theme:"minimal",
				scrollInertia: 60,
			});				
		});
	})(jQuery);	

	/*$('.transaction-row').bind('click', function() {
		var transaction_id = $(this).attr('data-transaction');
		
		$.ajax({
			url: base_url+'showTrusteeTransactionInfo',
			type: 'post',
			data: {_token: CSRF_TOKEN, transaction_id: transaction_id},
			beforeSend: function() {
				var content = $('.preloader_doc').html();
				$('.transaction-container').html(content);
			},
			success: function(output) {
				$('.transaction-container').html(output);

				$('.transaction-row').find('li').removeClass('active');

				$('.transaction-content-row'+transaction_id).addClass('active');
			}
		});
	});*/
});	

$(document).ready(function() {
	$('.mtb_category_scroller').owlCarousel({
		margin: 10,
		loop: false,
		nav:true,
		navText: ["<img src='{{ asset('public/assets/') }}/images/scroll-arrow.svg'>","<img src='{{ asset('public/assets/') }}/images/scroll-arrow.svg'>"],  
		autoWidth: true,
		items: 4
	});
});

</script>