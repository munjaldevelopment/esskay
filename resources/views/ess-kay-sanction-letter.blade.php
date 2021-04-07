<div class="main-tab-details">
	<div class="white-box outstanding-box">
		<div class="outstanding-table">
			<h3>Particulars</h3>

			<div class="custom-table-area">
				<div class="row-fluid">
					<div class="col-sm-6 offset-3">
						@foreach($sanctionData as $sanctionRow)
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th colspan="2">Particulars</th>
									</tr>
								</thead>

								<tbody>
									<tr>
										<td>Bank</td>
										<td>{{ $sanctionRow->bank_name }}</td>
									</tr>
									<tr>
										<td>Type of Facility</td>
										<td>{{ $sanctionRow->type_facility }}</td>
									</tr>
									<tr>
										<td>Facility Amount</td>
										<td>{{ $sanctionRow->facility_amount }}</td>
									</tr>
									<tr>
										<td>ROI</td>
										<td>{{ $sanctionRow->roi }}</td>
									</tr>
									<tr>
										<td>All-inclusive ROI</td>
										<td>{{ $sanctionRow->all_incluside_roi }}</td>
									</tr>
									<tr>
										<td>Processing Fees</td>
										<td>{{ $sanctionRow->processing_fees }}</td>
									</tr>
									<tr>
										<td>Arranger Fees</td>
										<td>{{ $sanctionRow->arranger_fees }}</td>
									</tr>
									<tr>
										<td>Stamp Duty Fees</td>
										<td>{{ $sanctionRow->stamp_duty_fees }}</td>
									</tr>
									<tr>
										<td>Tenor</td>
										<td>{{ $sanctionRow->tenor }}</td>
									</tr>
									<tr>
										<td>Security Cover</td>
										<td>{{ $sanctionRow->security_cover }}</td>
									</tr>
									<tr>
										<td>Cash Collateral</td>
										<td>{{ $sanctionRow->cash_collateral }}</td>
									</tr>
									<tr>
										<td>Personal Guarantee</td>
										<td>{{ $sanctionRow->personal_guarantee }}</td>
									</tr>
									<tr>
										<td>Intermediary</td>
										<td>{{ $sanctionRow->intermediary }}</td>
									</tr>
									<tr>
										<td>Sanction letter</td>
										<td>{{ $sanctionRow->sanction_letter }}</td>
									</tr>
								</tbody>
							</table>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

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
$(document).ready(function() {
	
	var base_url = $('base').attr('href');
	
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	
});
</script>
