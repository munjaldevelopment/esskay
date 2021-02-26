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
			url: base_url+'showChildDoc',
			type: 'post',
			data: {_token: CSRF_TOKEN, category_id: category, document_date: document_date},
			beforeSend: function() {
				var content = $('.preloader_doc').html();
				$('.sub-doc-container').html(content);
			},
			success: function(output) {
				$('.sub-doc-container').html(output);

				$('.assign_date').val('{{ $current_year }}');

				$('.sub-category-row').removeClass('active');

				$('.sub-sub-category'+category).addClass('active');
			}
		});
	});
});
</script>