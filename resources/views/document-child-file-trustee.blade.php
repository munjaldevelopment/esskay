@if($is_timeline)
<div class="mtd-timeline">
	<ul>
		@php
			$count = 1;
		@endphp
		@foreach($documentDateData as $k => $doc_date)
		<li class="sub-time-container @if($docu_date == $doc_date) active @endif" name="{{ $doc_date }}">
			<a href="javascript:;" class="btn-child-date" data-date="{{ $doc_date }}">
				{{ $doc_date }}
			</a>
		</li>
			@php
				$count++;
			@endphp
		@endforeach
	</ul>
</div>
@endif

<div class="mtd-timeline-content">
	<div class="border-title">	
		<span>{{ $category_name }}</span>
	</div>

	<div class="mtd-timline-document">
		<div class="row">
			@if($docData)
				@foreach($docData as $id1 => $doc)
				<div class="col-md-6 col-sm-12">
					<div class="mtd-doc-box">											
						<div class="mtdd-doc-img">
							<i class="fa fa-file-{{ $doc['ext'] }}-o" aria-hidden="true"></i>
						</div>
						<div class="mtdd-doc-cont">
							<h4> {{ $doc['document_heading'] }} </h4>	
							<p>{!! date('F d, Y', strtotime($doc['expiry_date'])) !!}</p>													
						</div>
						<div class="download-container{{ $doc['id'] }} mtdd-doc-check">
							@if($doc['doc_download'] > 0)
							<img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt="">
							@endif
						</div>
						<div class="mtd-doc-hover">
							<ul>
								<li>
									@if($doc['ext'] == 'pdf')
									<a href="{{ asset('/') }}previewDocTrustee/{{ base64_encode($doc['id']) }}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
									@endif
								</li>

								<li>
									<a href="{{ asset('/') }}downloadDocTrustee/{{ base64_encode($doc['id']) }}" onclick="showDownloadIcon('{{ $doc['id'] }}');" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a>
								</li>
							</ul>
						</div>
					</div>
				</div>

					@if(($id1 % 2) == 1)
						</div>
						<div class="row">
					@endif
				@endforeach
			@endif
		</div>
	</div>
</div>

<script type="text/javascript">
	function showDownloadIcon(doc_id)
	{
		$('.download-container'+doc_id).html('<img src="{{ asset('public/assets/') }}/images/doc-check-icon.svg" alt="">');
	}

$(function () {
	var base_url = $('base').attr('href');
	
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

	$('.btn-child-date').bind('click', function() {
		var date1 = $(this).attr('data-date');		
		
		//alert(date1);
		$('.assign_date').val(date1);
		
		$('.sub-time-container').removeClass('active-time');
				
		$('li.sub-time-container[name="'+date1+'"]').addClass("active-time");

		var category = '{{ $category_id }}';
		
		var document_date = date1;
		
		$.ajax({
			url: base_url+'showChildDocTrustee',
			type: 'post',
			data: {_token: CSRF_TOKEN, category_id: category, document_date: document_date},
			beforeSend: function() {
				var content = $('.preloader_doc').html();
				$('.sub-doc-container').html(content);
			},
			success: function(output) {
				$('.sub-doc-container').html(output);

				$('.sub-category-row').removeClass('active');

				$('.sub-sub-category'+category).addClass('active');
			}
		});
	});
});
</script>