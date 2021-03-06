<input type="hidden" id="info_transaction_id" name="info_transaction_id" value="{{ $transaction_id }}" />
<input type="hidden" id="report_type" name="report_type" value="{{ $report_type }}" />

<div class="mtd-timeline timeline-data @if($report_type == 2) @else d-none @endif">
	<ul>
		@foreach($document_date as $k => $row)
		<li @if($k == $docu_date) class="active" @endif><a href="javascript:;" class="btn-child-date" data-date="{{ $row }}">{{ $row}}</a></li>
		@endforeach
	</ul>
</div>

@if($report_type == 1 || $report_type == 5 || $report_type == 6 || $report_type == 7)
<div class="mtd-timeline-content">
	<div class="border-title d-none hide">	
		<span>{{ $heading_title }}</span>
	</div>

	<div class="mtd-accordian">
		 <div id="accordion">
		 	@if($termSheetDocData)
			<div class="card">				
				<div class="card-header">
					<a class="card-link" data-toggle="collapse" href="#execuled_doc_1" aria-expanded="true">
						@if($report_type == 1)
						Term Sheet
						@elseif($report_type == 5)
						CHG-9
						@elseif($report_type == 6)
						CHG-4
						@elseif($report_type == 7)
						CHG-1
						@endif
						<span class="collapsed accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
						<span class="expanded accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
					</a>
				</div>
				<div id="execuled_doc_1" class="collapse show" data-parent="#accordion" >
				  	<div class="card-body">
						<div class="mtd-timline-document">
							<div class="row">
								@foreach($termSheetDocData as $k => $row)
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-{{ $row['ext'] }}-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>{{ $row['document_name'] }} </h4>
											<p>{!! date('F d, Y', strtotime($row['expiry_date'])) !!}</p>
										</div>
										<div class="download-container{{ $row['id'] }} mtdd-doc-check">
											@if($row['doc_download'] > 0)
											<img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt="">
											@endif
										</div>
										<div class="mtd-doc-hover">
											<ul>
												<li>
													@if($row['ext'] == 'pdf')
													<a href="{{ asset('/') }}previewTransDocTrustee/{{ base64_encode($row['id']) }}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
													@endif
												</li>
												<li>
													<a href="{{ asset('/') }}downloadTransDocTrustee/{{ base64_encode($row['id']) }}" onclick="showDownloadIcon('{{ $row['id'] }}');" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a>
												</li>
											</ul>
										</div>
									</div>
								</div>
								@endforeach
								
							</div>
						</div>
				  	</div>
				</div>
			</div>
			@endif

			@if($serviceAgreementDocData)
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
								@foreach($serviceAgreementDocData as $k => $row)
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-{{ $row['ext'] }}-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>{{ $row['document_name'] }} </h4>	
											<p>{!! date('F d, Y', strtotime($row['expiry_date'])) !!}</p>
										</div>
										<div class="download-container{{ $row['id'] }} mtdd-doc-check">
											@if($row['doc_download'] > 0)
											<img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt="">
											@endif
										</div>
										<div class="mtd-doc-hover">
											<ul>
												<li>@if($row['ext'] == 'pdf')
													<a href="{{ asset('/') }}previewTransDocTrustee/{{ base64_encode($row['id']) }}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
													@endif</li>
												<li><a href="{{ asset('/') }}downloadTransDocTrustee/{{ base64_encode($row['id']) }}" onclick="showDownloadIcon('{{ $row['id'] }}');" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>		
			@endif

			@if($accountAgreementDocData)
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
								@foreach($accountAgreementDocData as $k => $row)
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-{{ $row['ext'] }}-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>{{ $row['document_name'] }} </h4>	
											<p>{!! date('F d, Y', strtotime($row['expiry_date'])) !!}</p>
										</div>
										<div class="download-container{{ $row['id'] }} mtdd-doc-check">
											@if($row['doc_download'] > 0)
											<img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt="">
											@endif
										</div>
										<div class="mtd-doc-hover">
											<ul>
												<li>@if($row['ext'] == 'pdf')
													<a href="{{ asset('/') }}previewTransDocTrustee/{{ base64_encode($row['id']) }}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
													@endif</li>
												<li><a href="{{ asset('/') }}downloadTransDocTrustee/{{ base64_encode($row['id']) }}" onclick="showDownloadIcon('{{ $row['id'] }}');" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
								@endforeach
								
							</div>
						</div>
				  	</div>
				</div>
			</div>
			@endif

			@if($assignmentAgreementDocData)
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
								@foreach($assignmentAgreementDocData as $k => $row)
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-{{ $row['ext'] }}-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>{{ $row['document_name'] }} </h4>	
											<p>{!! date('F d, Y', strtotime($row['expiry_date'])) !!}</p>
										</div>
										<div class="download-container{{ $row['id'] }} mtdd-doc-check">
											@if($row['doc_download'] > 0)
											<img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt="">
											@endif
										</div>
										<div class="mtd-doc-hover">
											<ul>
												<li>@if($row['ext'] == 'pdf')
													<a href="{{ asset('/') }}previewTransDocTrustee/{{ base64_encode($row['id']) }}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
													@endif</li>
												<li><a href="{{ asset('/') }}downloadTransDocTrustee/{{ base64_encode($row['id']) }}" onclick="showDownloadIcon('{{ $row['id'] }}');" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
								@endforeach
							</div>
						</div>
				  	</div>
				</div>
			</div>
			@endif

			@if($trustDeedDocData)
			<div class="card">
				<div class="card-header">
					<a class="card-link collapsed" data-toggle="collapse"  href="#execuled_doc_5" aria-expanded="false">
						Trust Deed
						<span class="collapsed accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
						<span class="expanded accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
					</a>
				</div>
				<div id="execuled_doc_5" class="panel-collapse collapse" data-parent="#accordion">
				  <div class="card-body">
						<div class="mtd-timline-document">
							<div class="row">
								@foreach($trustDeedDocData as $k => $row)
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-{{ $row['ext'] }}-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>{{ $row['document_name'] }} </h4>	
											<p>{!! date('F d, Y', strtotime($row['expiry_date'])) !!}</p>
										</div>
										<div class="download-container{{ $row['id'] }} mtdd-doc-check">
											@if($row['doc_download'] > 0)
											<img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt="">
											@endif
										</div>
										<div class="mtd-doc-hover">
											<ul>
												<li>@if($row['ext'] == 'pdf')
													<a href="{{ asset('/') }}previewTransDocTrustee/{{ base64_encode($row['id']) }}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
													@endif</li>
												<li><a href="{{ asset('/') }}downloadTransDocTrustee/{{ base64_encode($row['id']) }}" onclick="showDownloadIcon('{{ $row['id'] }}');" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
								@endforeach
							</div>
						</div>
				  	</div>
				</div>
			</div>
			@endif

			@if($imDocData)
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
								
								@foreach($imDocData as $k => $row)
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-{{ $row['ext'] }}-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>{{ $row['document_name'] }} </h4>	
											<p>{!! date('F d, Y', strtotime($row['expiry_date'])) !!}</p>
										</div>
										<div class="download-container{{ $row['id'] }} mtdd-doc-check">
											@if($row['doc_download'] > 0)
											<img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt="">
											@endif
										</div>
										<div class="mtd-doc-hover">
											<ul>
												<li>@if($row['ext'] == 'pdf')
													<a href="{{ asset('/') }}previewTransDocTrustee/{{ base64_encode($row['id']) }}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
													@endif</li>
												<li><a href="{{ asset('/') }}downloadTransDocTrustee/{{ base64_encode($row['id']) }}" onclick="showDownloadIcon('{{ $row['id'] }}');" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
								@endforeach
							</div>
						</div>
				  	</div>
				</div>
			</div>
			@endif

			@if($anyotherDocData)
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
								@foreach($anyotherDocData as $k => $row)
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-{{ $row['ext'] }}-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>{{ $row['document_name'] }} </h4>	
											<p>{!! date('F d, Y', strtotime($row['expiry_date'])) !!}</p>
										</div>
										<div class="download-container{{ $row['id'] }} mtdd-doc-check">
											@if($row['doc_download'] > 0)
											<img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt="">
											@endif
										</div>
										<div class="mtd-doc-hover">
											<ul>
												<li>@if($row['ext'] == 'pdf')
													<a href="{{ asset('/') }}previewTransDocTrustee/{{ base64_encode($row['id']) }}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
													@endif</li>
												<li><a href="{{ asset('/') }}downloadTransDocTrustee/{{ base64_encode($row['id']) }}" onclick="showDownloadIcon('{{ $row['id'] }}');" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
								@endforeach
							</div>
						</div>
				  	</div>
				</div>
			</div>
			@endif
		</div>
	</div>
</div>
@elseif($report_type == 2)
<div class="mtd-timeline-content">
	<div class="border-title">	
		<span>{{ $heading_title }}</span>
	</div>

	<div class="mtd-accordian">
		 <div id="accordion">

		 	@if($monthlyDecDocData)
		 	<div class="card">
				<div class="card-header">
					<a class="card-link collapsed" data-toggle="collapse"  href="#execuled_doc_12" aria-expanded="false">
						Dec {{ $docu_date }}
						<span class="collapsed accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
						<span class="expanded accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
					</a>
				</div>
				<div id="execuled_doc_12" class="panel-collapse collapse" data-parent="#accordion">
				  	<div class="card-body">
						<div class="mtd-timline-document">
							<div class="row">
								@foreach($monthlyDecDocData as $k => $row)
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-{{ $row['ext'] }}-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>{{ $row['document_name'] }} </h4>	
											<p>{!! date('F d, Y', strtotime($row['expiry_date'])) !!}</p>
										</div>
										<div class="download-container{{ $row['id'] }} mtdd-doc-check">
											@if($row['doc_download'] > 0)
											<img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt="">
											@endif
										</div>
										<div class="mtd-doc-hover">
											<ul>
												<li>@if($row['ext'] == 'pdf')
													<a href="{{ asset('/') }}previewTransDocTrustee/{{ base64_encode($row['id']) }}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
													@endif</li>
												<li><a href="{{ asset('/') }}downloadTransDocTrustee/{{ base64_encode($row['id']) }}" onclick="showDownloadIcon('{{ $row['id'] }}');" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
								@endforeach
							</div>
						</div>
				  	</div>
				</div>
			</div>
			@endif

			@if($monthlyNovDocData)
			<div class="card">
				<div class="card-header">
					<a class="card-link collapsed" data-toggle="collapse"  href="#execuled_doc_11" aria-expanded="false">
						Nov {{ $docu_date }}
						<span class="collapsed accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
						<span class="expanded accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
					</a>
				</div>
				<div id="execuled_doc_11" class="panel-collapse collapse" data-parent="#accordion">
				  	<div class="card-body">
						<div class="mtd-timline-document">
							<div class="row">
								@foreach($monthlyNovDocData as $k => $row)
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-{{ $row['ext'] }}-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>{{ $row['document_name'] }} </h4>	
											<p>{!! date('F d, Y', strtotime($row['expiry_date'])) !!}</p>
										</div>
										<div class="download-container{{ $row['id'] }} mtdd-doc-check">
											@if($row['doc_download'] > 0)
											<img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt="">
											@endif
										</div>
										<div class="mtd-doc-hover">
											<ul>
												<li>@if($row['ext'] == 'pdf')
													<a href="{{ asset('/') }}previewTransDocTrustee/{{ base64_encode($row['id']) }}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
													@endif</li>
												<li><a href="{{ asset('/') }}downloadTransDocTrustee/{{ base64_encode($row['id']) }}" onclick="showDownloadIcon('{{ $row['id'] }}');" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
								@endforeach
							</div>
						</div>
				  	</div>
				</div>
			</div>
			@endif

			@if($monthlyOctDocData)
			<div class="card">
				<div class="card-header">
					<a class="card-link collapsed" data-toggle="collapse"  href="#execuled_doc_10" aria-expanded="false">
						Oct {{ $docu_date }}
						<span class="collapsed accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
						<span class="expanded accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
					</a>
				</div>
				<div id="execuled_doc_10" class="panel-collapse collapse" data-parent="#accordion">
				  	<div class="card-body">
						<div class="mtd-timline-document">
							<div class="row">
								@foreach($monthlyOctDocData as $k => $row)
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-{{ $row['ext'] }}-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>{{ $row['document_name'] }} </h4>	
											<p>{!! date('F d, Y', strtotime($row['expiry_date'])) !!}</p>
										</div>
										<div class="download-container{{ $row['id'] }} mtdd-doc-check">
											@if($row['doc_download'] > 0)
											<img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt="">
											@endif
										</div>
										<div class="mtd-doc-hover">
											<ul>
												<li>@if($row['ext'] == 'pdf')
													<a href="{{ asset('/') }}previewTransDocTrustee/{{ base64_encode($row['id']) }}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
													@endif</li>
												<li><a href="{{ asset('/') }}downloadTransDocTrustee/{{ base64_encode($row['id']) }}" onclick="showDownloadIcon('{{ $row['id'] }}');" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
								@endforeach
							</div>
						</div>
				  	</div>
				</div>
			</div>
			@endif

			@if($monthlySepDocData)
			<div class="card">
				<div class="card-header">
					<a class="card-link collapsed" data-toggle="collapse"  href="#execuled_doc_9" aria-expanded="false">
						Sept {{ $docu_date }}
						<span class="collapsed accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
						<span class="expanded accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
					</a>
				</div>
				<div id="execuled_doc_9" class="panel-collapse collapse" data-parent="#accordion">
				  	<div class="card-body">
						<div class="mtd-timline-document">
							<div class="row">
								@foreach($monthlySepDocData as $k => $row)
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-{{ $row['ext'] }}-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>{{ $row['document_name'] }} </h4>	
											<p>{!! date('F d, Y', strtotime($row['expiry_date'])) !!}</p>
										</div>
										<div class="download-container{{ $row['id'] }} mtdd-doc-check">
											@if($row['doc_download'] > 0)
											<img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt="">
											@endif
										</div>
										<div class="mtd-doc-hover">
											<ul>
												<li>@if($row['ext'] == 'pdf')
													<a href="{{ asset('/') }}previewTransDocTrustee/{{ base64_encode($row['id']) }}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
													@endif</li>
												<li><a href="{{ asset('/') }}downloadTransDocTrustee/{{ base64_encode($row['id']) }}" onclick="showDownloadIcon('{{ $row['id'] }}');" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
								@endforeach
							</div>
						</div>
				  	</div>
				</div>
			</div>
			@endif

			@if($monthlyAugDocData)
			<div class="card">
				<div class="card-header">
					<a class="card-link collapsed" data-toggle="collapse"  href="#execuled_doc_8" aria-expanded="false">
						August {{ $docu_date }}
						<span class="collapsed accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
						<span class="expanded accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
					</a>
				</div>
				<div id="execuled_doc_8" class="panel-collapse collapse" data-parent="#accordion">
				  	<div class="card-body">
						<div class="mtd-timline-document">
							<div class="row">
								@foreach($monthlyAugDocData as $k => $row)
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-{{ $row['ext'] }}-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>{{ $row['document_name'] }} </h4>	
											<p>{!! date('F d, Y', strtotime($row['expiry_date'])) !!}</p>
										</div>
										<div class="download-container{{ $row['id'] }} mtdd-doc-check">
											@if($row['doc_download'] > 0)
											<img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt="">
											@endif
										</div>
										<div class="mtd-doc-hover">
											<ul>
												<li>@if($row['ext'] == 'pdf')
													<a href="{{ asset('/') }}previewTransDocTrustee/{{ base64_encode($row['id']) }}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
													@endif</li>
												<li><a href="{{ asset('/') }}downloadTransDocTrustee/{{ base64_encode($row['id']) }}" onclick="showDownloadIcon('{{ $row['id'] }}');" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
								@endforeach
							</div>
						</div>
				  	</div>
				</div>
			</div>
			@endif

			@if($monthlyJulyDocData)
			<div class="card">
				<div class="card-header">
					<a class="card-link collapsed" data-toggle="collapse"  href="#execuled_doc_7" aria-expanded="false">
						July {{ $docu_date }}
						<span class="collapsed accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
						<span class="expanded accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
					</a>
				</div>
				<div id="execuled_doc_7" class="panel-collapse collapse" data-parent="#accordion">
				  <div class="card-body">
						<div class="mtd-timline-document">
							<div class="row">
								@foreach($monthlyJulyDocData as $k => $row)
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-{{ $row['ext'] }}-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>{{ $row['document_name'] }} </h4>	
											<p>{!! date('F d, Y', strtotime($row['expiry_date'])) !!}</p>
										</div>
										<div class="download-container{{ $row['id'] }} mtdd-doc-check">
											@if($row['doc_download'] > 0)
											<img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt="">
											@endif
										</div>
										<div class="mtd-doc-hover">
											<ul>
												<li>@if($row['ext'] == 'pdf')
													<a href="{{ asset('/') }}previewTransDocTrustee/{{ base64_encode($row['id']) }}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
													@endif</li>
												<li><a href="{{ asset('/') }}downloadTransDocTrustee/{{ base64_encode($row['id']) }}" onclick="showDownloadIcon('{{ $row['id'] }}');" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
								@endforeach
							</div>
						</div>
				  	</div>
				</div>
			</div>
			@endif

			@if($monthlyJuneDocData)
			<div class="card">
				<div class="card-header">
					<a class="card-link collapsed" data-toggle="collapse"  href="#execuled_doc_6" aria-expanded="false">
						June {{ $docu_date }}
						<span class="collapsed accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
						<span class="expanded accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
					</a>
				</div>
				<div id="execuled_doc_6" class="panel-collapse collapse" data-parent="#accordion">
				  	<div class="card-body">
						<div class="mtd-timline-document">
							<div class="row">
								@foreach($monthlyJuneDocData as $k => $row)
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-{{ $row['ext'] }}-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>{{ $row['document_name'] }} </h4>	
											<p>{!! date('F d, Y', strtotime($row['expiry_date'])) !!}</p>
										</div>
										<div class="download-container{{ $row['id'] }} mtdd-doc-check">
											@if($row['doc_download'] > 0)
											<img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt="">
											@endif
										</div>
										<div class="mtd-doc-hover">
											<ul>
												<li>@if($row['ext'] == 'pdf')
													<a href="{{ asset('/') }}previewTransDocTrustee/{{ base64_encode($row['id']) }}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
													@endif</li>
												<li><a href="{{ asset('/') }}downloadTransDocTrustee/{{ base64_encode($row['id']) }}" onclick="showDownloadIcon('{{ $row['id'] }}');" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
								@endforeach
							</div>
						</div>
				  	</div>
				</div>
			</div>
			@endif

			@if($monthlyMayDocData)
			<div class="card">
				<div class="card-header">
					<a class="card-link collapsed" data-toggle="collapse"  href="#execuled_doc_5" aria-expanded="false">
						May {{ $docu_date }}
						<span class="collapsed accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
						<span class="expanded accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
					</a>
				</div>
				<div id="execuled_doc_5" class="panel-collapse collapse" data-parent="#accordion">
				  <div class="card-body">
						<div class="mtd-timline-document">
							<div class="row">
								@foreach($monthlyMayDocData as $k => $row)
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-{{ $row['ext'] }}-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>{{ $row['document_name'] }} </h4>	
											<p>{!! date('F d, Y', strtotime($row['expiry_date'])) !!}</p>
										</div>
										<div class="download-container{{ $row['id'] }} mtdd-doc-check">
											@if($row['doc_download'] > 0)
											<img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt="">
											@endif
										</div>
										<div class="mtd-doc-hover">
											<ul>
												<li>@if($row['ext'] == 'pdf')
													<a href="{{ asset('/') }}previewTransDocTrustee/{{ base64_encode($row['id']) }}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
													@endif</li>
												<li><a href="{{ asset('/') }}downloadTransDocTrustee/{{ base64_encode($row['id']) }}" onclick="showDownloadIcon('{{ $row['id'] }}');" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
								@endforeach
							</div>
						</div>
				  	</div>
				</div>
			</div>
			@endif

			@if($monthlyAprDocData)
			<div class="card">
				<div class="card-header">
					<a class="card-link collapsed" data-toggle="collapse"  href="#execuled_doc_4" aria-expanded="false">
						April {{ $docu_date }}
						<span class="collapsed accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
						<span class="expanded accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
					</a>
				</div>
				<div id="execuled_doc_4" class="panel-collapse collapse" data-parent="#accordion">
				  <div class="card-body">
						<div class="mtd-timline-document">
							<div class="row">
								@foreach($monthlyAprDocData as $k => $row)
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-{{ $row['ext'] }}-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>{{ $row['document_name'] }} </h4>	
											<p>{!! date('F d, Y', strtotime($row['expiry_date'])) !!}</p>
										</div>
										<div class="download-container{{ $row['id'] }} mtdd-doc-check">
											@if($row['doc_download'] > 0)
											<img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt="">
											@endif
										</div>
										<div class="mtd-doc-hover">
											<ul>
												<li>@if($row['ext'] == 'pdf')
													<a href="{{ asset('/') }}previewTransDocTrustee/{{ base64_encode($row['id']) }}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
													@endif</li>
												<li><a href="{{ asset('/') }}downloadTransDocTrustee/{{ base64_encode($row['id']) }}" onclick="showDownloadIcon('{{ $row['id'] }}');" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
								@endforeach
							</div>
						</div>
				  	</div>
				</div>
			</div>
			@endif

			@if($monthlyMarDocData)
			<div class="card">
				<div class="card-header">
					<a class="card-link collapsed" data-toggle="collapse"  href="#execuled_doc_3" aria-expanded="false">
						March {{ $docu_date }}
						<span class="collapsed accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
						<span class="expanded accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
					</a>
				</div>
				<div id="execuled_doc_3" class="panel-collapse collapse" data-parent="#accordion">
				  	<div class="card-body">
						<div class="mtd-timline-document">
							<div class="row">
								@foreach($monthlyMarDocData as $k => $row)
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-{{ $row['ext'] }}-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>{{ $row['document_name'] }} </h4>	
											<p>{!! date('F d, Y', strtotime($row['expiry_date'])) !!}</p>
										</div>
										<div class="download-container{{ $row['id'] }} mtdd-doc-check">
											@if($row['doc_download'] > 0)
											<img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt="">
											@endif
										</div>
										<div class="mtd-doc-hover">
											<ul>
												<li>@if($row['ext'] == 'pdf')
													<a href="{{ asset('/') }}previewTransDocTrustee/{{ base64_encode($row['id']) }}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
													@endif</li>
												<li><a href="{{ asset('/') }}downloadTransDocTrustee/{{ base64_encode($row['id']) }}" onclick="showDownloadIcon('{{ $row['id'] }}');" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
								@endforeach
							</div>
						</div>
				  	</div>
				</div>
			</div>
			@endif

			@if($monthlyFebDocData)
			<div class="card">
				<div class="card-header">
					<a class="card-link collapsed" data-toggle="collapse" href="#execuled_doc_2" aria-expanded="false">
						Feb {{ $docu_date }}
						<span class="collapsed accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
						<span class="expanded accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
					</a>
				</div>
				<div id="execuled_doc_2" class="panel-collapse collapse" data-parent="#accordion">
				  	<div class="card-body">
						<div class="mtd-timline-document">
							<div class="row">
								@foreach($monthlyFebDocData as $k => $row)
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-{{ $row['ext'] }}-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>{{ $row['document_name'] }} </h4>	
											<p>{!! date('F d, Y', strtotime($row['expiry_date'])) !!}</p>
										</div>
										<div class="download-container{{ $row['id'] }} mtdd-doc-check">
											@if($row['doc_download'] > 0)
											<img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt="">
											@endif
										</div>
										<div class="mtd-doc-hover">
											<ul>
												<li>@if($row['ext'] == 'pdf')
													<a href="{{ asset('/') }}previewTransDocTrustee/{{ base64_encode($row['id']) }}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
													@endif</li>
												<li><a href="{{ asset('/') }}downloadTransDocTrustee/{{ base64_encode($row['id']) }}" onclick="showDownloadIcon('{{ $row['id'] }}');" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>
			@endif

			@if($monthlyJanDocData)
			<div class="card">
				<div class="card-header">
					<a class="card-link collapsed" data-toggle="collapse" href="#execuled_doc_1" aria-expanded="false">
						Jan {{ $docu_date }}
						<span class="collapsed accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
						<span class="expanded accordian-dropi-icon"><p><img src="{{ asset('public/assets/') }}/images/accordian-arrow-icon.svg" alt=""></p></span>
					</a>
				</div>
				<div id="execuled_doc_1" class="collapse" data-parent="#accordion" >
				  	<div class="card-body">
						<div class="mtd-timline-document">
							<div class="row">
								@foreach($monthlyJanDocData as $k => $row)
								<div class="col-md-6 col-sm-12">
									<div class="mtd-doc-box">											
										<div class="mtdd-doc-img">
											<i class="fa fa-file-{{ $row['ext'] }}-o" aria-hidden="true"></i>
										</div>
										<div class="mtdd-doc-cont">
											<h4>{{ $row['document_name'] }} </h4>	
											<p>{!! date('F d, Y', strtotime($row['expiry_date'])) !!}</p>
										</div>
										<div class="download-container{{ $row['id'] }} mtdd-doc-check">
											@if($row['doc_download'] > 0)
											<img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt="">
											@endif
										</div>
										<div class="mtd-doc-hover">
											<ul>
												<li>@if($row['ext'] == 'pdf')
													<a href="{{ asset('/') }}previewTransDocTrustee/{{ base64_encode($row['id']) }}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
													@endif</li>
												<li><a href="{{ asset('/') }}downloadTransDocTrustee/{{ base64_encode($row['id']) }}" onclick="showDownloadIcon('{{ $row['id'] }}');" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
								@endforeach
							</div>
						</div>
				  	</div>
				</div>
			</div>
			@endif
		</div>
	</div>
</div>
@else
<div class="mtd-timeline-content">
	<div class="border-title">	
		<span>{{ $heading_title }}</span>
	</div>

	<div class="alert alert-warning">Coming soon</div>
</div>
@endif

<script src="{{ asset('public/assets/') }}/js/jquery.mCustomScrollbar.concat.min.js"></script>	
<script src="{{ asset('public/assets/') }}/js/owl.carousel.js"></script>

<script>
	function showDownloadIcon(doc_id)
	{
		$('.download-container'+doc_id).html('<img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt="">');
	}

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

	$('.btn-child-date').bind('click', function() {
		var dateVal = $(this).attr('data-date');
		
		$.ajax({
			url: base_url+'assignTransactionDate',
			type: 'post',
			data: {_token: CSRF_TOKEN, dateVal: dateVal},
			beforeSend: function() {
				var content = $('.preloader_doc').html();
			},
			success: function(output) {
				var transaction_id = $('#info_transaction_id').val();
				var report_type = $('#report_type').val();

				$.ajax({
					url: base_url+'showTrusteeTransactionDocumentInfo',
					type: 'post',
					data: {_token: CSRF_TOKEN, transaction_id: transaction_id, report_type: report_type},
					beforeSend: function() {
						var content = $('.preloader_doc').html();
						$('.trustee-transaction-document-container').html(content);
					},
					success: function(output) {
						$('.report-type-container').removeClass('active');

						$(this).parent().find('.report-type-container').addClass('active');
						$('.trustee-transaction-document-container').html(output);
					}
				});
			}
		});
	});
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