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
							<th class="border-bottom">Processing Fees %</th>
							<th class="border-bottom">Processing Fees Amount</th>
							<th class="border-bottom">Arranger Fees %</th>
							<th class="border-bottom">Arranger Fees Amount</th>
							<th class="border-bottom">Other Charges Doc</th>
							<th class="border-bottom">Total Associated Cost</th>
							<th class="border-bottom">All Inclusive Cost</th>
							<th class="border-bottom">Financial Covenant</th>
							<th class="border-bottom">Rationale for Availing facility</th>
							<th class="border-bottom">Blended Cost</th>
							<th class="border-bottom">Stamp Duty Fees</th>
							<th class="border-bottom">Tenor</th>
							<th class="border-bottom">Security Cover</th>
							<th class="border-bottom">Cash Collateral</th>
							<th class="border-bottom">Personal Guarantee</th>
							<th class="border-bottom">Intermediary</th>
							<th class="border-bottom">Sanction Letter</th>
						</tr>
					</thead>
					<tbody>
						@foreach($sanctionLetterData as $row)
						<tr>
							<td class="text-justify">{{ $row->bank_name }}</td>
							<td>{{ $row->type_facility }}</td>
							<td>{{ $row->facility_amount }}</td>
							<td>{{ $row->roi }}</td>
							<td>{{ $row->processing_fees }}</td>
							<td>{{ $row->processing_fees_amount }}</td>
							<td>{{ $row->arranger_fees }}</td>
							<td>{{ $row->arranger_fees_amount }}</td>
							<td>{{ $row->other_charges_doc }}</td>
							<td>{{ $row->total_associated_cost }}</td>
							<td>{{ $row->all_inclusive_cost }}</td>
							<td>{!! $row->financial_covenant !!}</td>
							<td>{{ $row->rationale_availing }}</td>
							<td>{{ $row->blended_cost }}</td>
							<td>{{ $row->stamp_duty_fees }}</td>
							<td>{{ $row->tenor }}</td>
							<td>{{ $row->security_cover }}</td>
							<td>{{ $row->cash_collateral }}</td>
							<td>{{ $row->personal_guarantee }}</td>
							<td>{{ $row->intermediary }}</td>
							<td>{{ $row->sanction_letter }}</td>
						</tr>
						@endforeach
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