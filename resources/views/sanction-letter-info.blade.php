<div class="white-box outstanding-box">
	<div class="outstanding-table">
		<h3>Sanction Letters</h3>
		@if($sanctionLetterData)
			@foreach($sanctionLetterData as $row)
			<div class="custom-table-area">
				<div class="table-responsive">
					<table class="table">
						<tr>
							<th class="border-bottom">Bank Name</th>
							<td>{{ $row->bank_name }}</td>
						</tr>
						<tr>
							<th class="border-bottom">Type of Facility</th>
							<td>{{ $row->type_facility }}</td>
						</tr>
						<tr>
							<th class="border-bottom">Facility Amount</th>
							<td>{{ $row->facility_amount }}</td>
						</tr>
						<tr>
							<th class="border-bottom">ROI</th>
							<td>{{ $row->roi }}</td>
						</tr>
						<tr>
							<th class="border-bottom">All-inclusive ROI</th>
							<td>{{ $row->all_incluside_roi }}</td>
						</tr>
						<tr>
							<th class="border-bottom">Processing Fees %</th>
							<td>{{ $row->processing_fees }}</td>
						</tr>
						<tr>
							<th class="border-bottom">Processing Fees Amount</th>
							<td>{{ $row->processing_fees_amount }}</td>
						</tr>
						<tr>
							<th class="border-bottom">Arranger Fees %</th>
							<td>{{ $row->arranger_fees }}</td>
						</tr>
						<tr>
							<th class="border-bottom">Arranger Fees Amount</th>
							<td>{{ $row->arranger_fees_amount }}</td>
						</tr>
						<tr>
							<th class="border-bottom">Other Charges Doc</th>
							<td>{{ $row->other_charges_doc }}</td>
						</tr>
						<tr>
							<th class="border-bottom">Total Associated Cost</th>
							<td>{{ $row->total_associated_cost }}</td>
						</tr>
						<tr>
							<th class="border-bottom">All Inclusive Cost</th>
							<td>{{ $row->all_inclusive_cost }}</td>
						</tr>
						<tr>
							<th class="border-bottom">Financial Covenant</th>
							<td>{!! $row->financial_covenant !!}</td>
						</tr>
						<tr>
							<th class="border-bottom">Rationale for Availing facility</th>
							<td>{!! $row->rationale_availing !!}</td>
						</tr>
						<tr>
							<th class="border-bottom">Blended Cost</th>
							<td>{{ $row->blended_cost }}</td>
						</tr>
						<tr>
							<th class="border-bottom">Stamp Duty Fees</th>
							<td>{{ $row->stamp_duty_fees }}</td>
						</tr>
						<tr>
							<th class="border-bottom">Tenor</th>
							<td>{{ $row->tenor }}</td>
						</tr>
						<tr>
							<th class="border-bottom">Security Cover</th>
							<td>{{ $row->security_cover }}</td>
						</tr>
						<tr>
							<th class="border-bottom">Cash Collateral</th>
							<td>{{ $row->cash_collateral }}</td>
						</tr>
						<tr>
							<th class="border-bottom">Personal Guarantee</th>
							<td>{{ $row->personal_guarantee }}</td>
						</tr>
						<tr>
							<th class="border-bottom">Intermediary</th>
							<td>{{ $row->intermediary }}</td>
						</tr>
						<tr>
							<th class="border-bottom">Sanction Letter</th>
							<td>{{ $row->sanction_letter }}</td>
						</tr>
						<tr>
							<th style="min-width:120px;" class="border-bottom">Action</th>
							<td class="accept-sanction-container{{ $row->id }}">
								@if($trustee_id == 1)
									@if($row->is_approve1 == 0)<a class="btn btn-info accept-sanction1" data-id="{{ $row->id }}" href="javascript:;"><i class="fa fa-check"></i></a> 
									&nbsp;&nbsp; 
									<a class="btn btn-danger reject-sanction1" href="javascript:;"><i class="fa fa-times"></i></a>@endif
								@elseif($trustee_id == 2)
									@if($row->is_approve2 == 0)<a class="btn btn-info accept-sanction2" data-id="{{ $row->id }}" href="javascript:;"><i class="fa fa-check"></i></a>
									&nbsp;&nbsp;
									<a class="btn btn-danger reject-sanction2" href="javascript:;"><i class="fa fa-times"></i></a>
									@endif
								@elseif($trustee_id == 3)
									@if($row->is_approve3 == 0)<a class="btn btn-info accept-sanction3" data-id="{{ $row->id }}" href="javascript:;"><i class="fa fa-check"></i></a>
									&nbsp;&nbsp;
									<a class="btn btn-danger reject-sanction3" href="javascript:;"><i class="fa fa-times"></i></a>
									@endif
								@endif
							</td>
						</tr>
					</table>
				</div>	
			</div>
			@endforeach
		@endif
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

	$('.accept-sanction1').bind('click', function() {
		var sanction_id = $(this).attr('data-id');

		Swal.fire({
			title: 'Are you sure?',
			type: 'error',
	        showCancelButton: true,
	        confirmButtonColor: '#36c6d3',
	        cancelButtonColor: '#d33',
	        confirmButtonText: 'OK',
	        cancelButtonText: 'Cancel'
	    }).then((res) => {
	    	if(res.isConfirmed){
				$.ajax({
					url: base_url+'approveSanctionLetter1',
					type: 'post',
					data: {_token: CSRF_TOKEN, sanction_id: sanction_id},
					beforeSend: function() {
						var content = $('.preloader_doc').html();
					},
					success: function(output) {
						$('.accept-sanction-container'+sanction_id).addClass('d-none');

						Swal.fire({
							title: 'Approved',
							title: 'Your file has been approved.',
							type: 'success'
					    });
					}
				});
			} else {
	        	Swal.fire({
					title: 'Cancelled',
					title: 'Your file has been cancelled.',
					type: 'warning'
			    });
			}
		});
	});

	$('.accept-sanction2').bind('click', function() {
		var sanction_id = $(this).attr('data-id');

		Swal.fire({
			title: 'Are you sure?',
			type: 'error',
	        showCancelButton: true,
	        confirmButtonColor: '#36c6d3',
	        cancelButtonColor: '#d33',
	        confirmButtonText: 'OK',
	        cancelButtonText: 'Cancel'
	    }).then((res) => {
	    	if(res.isConfirmed){
	    		$.ajax({
					url: base_url+'approveSanctionLetter2',
					type: 'post',
					data: {_token: CSRF_TOKEN, sanction_id: sanction_id},
					beforeSend: function() {
						var content = $('.preloader_doc').html();
					},
					success: function(output) {
						$('.accept-sanction-container'+sanction_id).addClass('d-none');

						Swal.fire({
							title: 'Approved',
							title: 'Your file has been approved.',
							type: 'success'
					    });
					}
				});
			} else {
	        	Swal.fire({
					title: 'Cancelled',
					title: 'Your file has been cancelled.',
					type: 'warning'
			    });
			}
		});
	});

	$('.accept-sanction3').bind('click', function() {
		var sanction_id = $(this).attr('data-id');

		Swal.fire({
			title: 'Are you sure?',
			type: 'error',
	        showCancelButton: true,
	        confirmButtonColor: '#36c6d3',
	        cancelButtonColor: '#d33',
	        confirmButtonText: 'OK',
	        cancelButtonText: 'Cancel'
	    }).then((res) => {
	    	if(res.isConfirmed){
				$.ajax({
					url: base_url+'approveSanctionLetter3',
					type: 'post',
					data: {_token: CSRF_TOKEN, sanction_id: sanction_id},
					beforeSend: function() {
						var content = $('.preloader_doc').html();
					},
					success: function(output) {
						$('.accept-sanction-container'+sanction_id).addClass('d-none');

						Swal.fire({
							title: 'Approved',
							title: 'Your file has been approved.',
							type: 'success'
					    });
					}
				});
			} else {
	        	Swal.fire({
					title: 'Cancelled',
					title: 'Your file has been cancelled.',
					type: 'warning'
			    });
			}
		});
	});
});
</script>