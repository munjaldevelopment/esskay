<div class="white-box outstanding-box">
	<div class="outstanding-table">
		<h3>Sanction Letters</h3>
		<div class="custom-table-area">
			<div class="table-responsive sanction-letter-content">
				<table class="table">
					<thead>
						<tr>
							
							<th style="min-width: 140px;">Bank Name</th>
							<th class="border-bottom">Type of Facility</th>
							<th class="border-bottom">Facility Amount</th>
							<th class="border-bottom">ROI</th>
							<th class="border-bottom">Processing Fees</th>
							<th class="border-bottom">Status</th>
							<th style="min-width:120px;" class="border-bottom">Preview</th>
							<th>Created By</th>
							
						</tr>
					</thead>
					<tbody>
						@if($sanctionLetterData)
							@foreach($sanctionLetterData as $row)
							<tr>
								<td class="text-justify">{{ $row->bank_name }}</td>
								<td>{{ $row->type_facility }}</td>
								<td>{{ $row->facility_amount }}</td>
								<td>{{ $row->roi }}</td>
								<td>{{ $row->processing_fees }}</td>
								<td>@if($row->status == 1) Accepted @elseif($row->status == 2) Rejected @else Pending @endif</td>
								<td class="">
									<a class="btn btn-info display-sanction" href="javascript:;" data-id="{{ $row->id }}"><i class="fa fa-eye"></i></a>
								</td>
								<td>{{ $row->created_name }}</td>
							</tr>
							@endforeach
						@endif
					</tbody>
				</table>	
			</div>	
		</div>
	</div>
</div>

<input type="hidden" id="category_id" value="{{ $category_id }}">

<div class="preloader_doc" style="display:none">
	<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin:auto;display:block;" width="200px" height="200px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
		<g transform="rotate(0 50 50)">
		  <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#0d12aa">
			<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.9166666666666666s" repeatCount="indefinite"></animate>
		  </rect>
		</g><g transform="rotate(30 50 50)">
		  <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#0d12aa">
			<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.8333333333333334s" repeatCount="indefinite"></animate>
		  </rect>
		</g><g transform="rotate(60 50 50)">
		  <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#0d12aa">
			<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.75s" repeatCount="indefinite"></animate>
		  </rect>
		</g><g transform="rotate(90 50 50)">
		  <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#0d12aa">
			<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.6666666666666666s" repeatCount="indefinite"></animate>
		  </rect>
		</g><g transform="rotate(120 50 50)">
		  <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#0d12aa">
			<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.5833333333333334s" repeatCount="indefinite"></animate>
		  </rect>
		</g><g transform="rotate(150 50 50)">
		  <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#0d12aa">
			<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.5s" repeatCount="indefinite"></animate>
		  </rect>
		</g><g transform="rotate(180 50 50)">
		  <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#0d12aa">
			<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.4166666666666667s" repeatCount="indefinite"></animate>
		  </rect>
		</g><g transform="rotate(210 50 50)">
		  <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#0d12aa">
			<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.3333333333333333s" repeatCount="indefinite"></animate>
		  </rect>
		</g><g transform="rotate(240 50 50)">
		  <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#0d12aa">
			<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.25s" repeatCount="indefinite"></animate>
		  </rect>
		</g><g transform="rotate(270 50 50)">
		  <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#0d12aa">
			<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.16666666666666666s" repeatCount="indefinite"></animate>
		  </rect>
		</g><g transform="rotate(300 50 50)">
		  <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#0d12aa">
			<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.08333333333333333s" repeatCount="indefinite"></animate>
		  </rect>
		</g><g transform="rotate(330 50 50)">
		  <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#0d12aa">
			<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="0s" repeatCount="indefinite"></animate>
		  </rect>
		</g>
		</svg>
</div>

<script src="{{ asset('public/assets/') }}/js/jquery.mCustomScrollbar.concat.min.js"></script>	
<script src="{{ asset('public/assets/') }}/js/owl.carousel.js"></script>

<script>
function showCategorySlider(key)
{
	$('.slider_bank_conatiner').addClass('d-none');
	$('.slider_bank_scroll'+key).removeClass('d-none');

	$('.slider-tab').removeClass('active');
	$('.slider-tab-content'+key).addClass('active');
}

$(document).ready(function() {
	
	var base_url = $('base').attr('href');
	
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

	$('.display-sanction').bind('click', function() {
		var sanction_id = $(this).attr('data-id');
		var category_id = $('#category_id').val();

		
		$.ajax({
			url: base_url+'displaySanctionLetter',
			type: 'post',
			data: {_token: CSRF_TOKEN, sanction_id: sanction_id, category_id: category_id},
			beforeSend: function() {
				var content = $('.preloader_doc').html();
				$('.sanction-letter-content').html(content);
			},
			success: function(output) {
				$('.sanction-letter-content').html(output);
			}
		});

	});
});
</script>