<div class="white-box outstanding-box">
	<div class="outstanding-table">
		<h3>Sanction Letters</h3>
		<div class="custom-table-area">
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th class="text-justify" style="min-width: 140px;">Bank Name</th>
							<th class="border-bottom">Type of Facility</th>
							<th class="border-bottom">Facility Amount</th>
							<th class="border-bottom">ROI</th>
							<th class="border-bottom">All-inclusive ROI</th>
							<th style="min-width:120px;" class="border-bottom">Action</th>
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
								<td>{{ $row->all_incluside_roi }}</td>
								<td class="accept-sanction-container{{ $row->id }}">
									<a class="btn btn-info accept-sanction1" href="javascript:;"><i class="fa fa-eye"></i></a>
								</td>
							</tr>
							@endforeach
						@endif
					</tbody>
				</table>	
			</div>	
		</div>
	</div>
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

	
});
</script>