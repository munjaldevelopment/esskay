@if($sanctionLetterData)
	<table class="table">
		<tr>
			<th style="width:50%;" class="border-bottom">Bank Name</th>
			<td style="width:50%;">{{ $sanctionLetterData->bank_name }}</td>
		</tr>
		<tr>
			<th class="border-bottom">Type of Facility</th>
			<td>{{ $sanctionLetterData->type_facility }}</td>
		</tr>
		<tr>
			<th class="border-bottom">Facility Amount</th>
			<td>{{ $sanctionLetterData->facility_amount }}</td>
		</tr>
		<tr>
			<th class="border-bottom">ROI</th>
			<td>{{ $sanctionLetterData->roi }}</td>
		</tr>
		<tr>
			<th class="border-bottom">All-inclusive ROI</th>
			<td>{{ $sanctionLetterData->all_incluside_roi }}</td>
		</tr>
		<tr>
			<th class="border-bottom">Processing Fees %</th>
			<td>{{ $sanctionLetterData->processing_fees }}</td>
		</tr>
		<tr>
			<th class="border-bottom">Processing Fees Amount</th>
			<td>{{ $sanctionLetterData->processing_fees_amount }}</td>
		</tr>
		<tr>
			<th class="border-bottom">Arranger Fees %</th>
			<td>{{ $sanctionLetterData->arranger_fees }}</td>
		</tr>
		<tr>
			<th class="border-bottom">Arranger Fees Amount</th>
			<td>{{ $sanctionLetterData->arranger_fees_amount }}</td>
		</tr>
		<tr>
			<th class="border-bottom">Other Charges Doc</th>
			<td>{{ $sanctionLetterData->other_charges_doc }}</td>
		</tr>
		<tr>
			<th class="border-bottom">Total Associated Cost</th>
			<td>{{ $sanctionLetterData->total_associated_cost }}</td>
		</tr>
		<tr>
			<th class="border-bottom">All Inclusive Cost</th>
			<td>{{ $sanctionLetterData->all_inclusive_cost }}</td>
		</tr>
		<tr>
			<th class="border-bottom">Financial Covenant</th>
			<td>{!! $sanctionLetterData->financial_covenant !!}</td>
		</tr>
		<tr>
			<th class="border-bottom">Rationale for Availing facility</th>
			<td>{!! $sanctionLetterData->rationale_availing !!}</td>
		</tr>
		<tr>
			<th class="border-bottom">Blended Cost</th>
			<td>{{ $sanctionLetterData->blended_cost }}</td>
		</tr>
		<tr>
			<th class="border-bottom">Stamp Duty Fees</th>
			<td>{{ $sanctionLetterData->stamp_duty_fees }}</td>
		</tr>
		<tr>
			<th class="border-bottom">Tenor</th>
			<td>{{ $sanctionLetterData->tenor }}</td>
		</tr>
		<tr>
			<th class="border-bottom">Security Cover</th>
			<td>{{ $sanctionLetterData->security_cover }}</td>
		</tr>
		<tr>
			<th class="border-bottom">Cash Collateral</th>
			<td>{{ $sanctionLetterData->cash_collateral }}</td>
		</tr>
		<tr>
			<th class="border-bottom">Personal Guarantee</th>
			<td>{{ $sanctionLetterData->personal_guarantee }}</td>
		</tr>
		<tr>
			<th class="border-bottom">Intermediary</th>
			<td>{{ $sanctionLetterData->intermediary }}</td>
		</tr>
		<tr>
			<th class="border-bottom">Sanction Letter</th>
			<td>{{ $sanctionLetterData->sanction_letter }}</td>
		</tr>
		<tr>
			<th class="border-bottom">Status</th>
			<td>@if($sanctionLetterData->status == 1) Accepted @elseif($sanctionLetterData->status == 2) Rejected @else Pending @endif</td>
		</tr>
		<tr>
			<th style="min-width:120px;" class="border-bottom">Action</th>
			<td class="accept-sanction-container{{ $sanctionLetterData->id }}">
				@if($trustee_id == 1)
					@if($sanctionLetterData->is_approve1 == 0)<a class="btn btn-info accept-sanction1" data-id="{{ $sanctionLetterData->id }}" href="javascript:;"><i class="fa fa-check"></i></a> 
					&nbsp;&nbsp; 
					<a class="btn btn-danger reject-sanction1" data-id="{{ $sanctionLetterData->id }}" href="javascript:;"><i class="fa fa-times"></i></a>@endif
				@elseif($trustee_id == 2)
					@if($sanctionLetterData->is_approve2 == 0)<a class="btn btn-info accept-sanction2" data-id="{{ $sanctionLetterData->id }}" href="javascript:;"><i class="fa fa-check"></i></a>
					&nbsp;&nbsp;
					<a class="btn btn-danger reject-sanction2" data-id="{{ $sanctionLetterData->id }}" href="javascript:;"><i class="fa fa-times"></i></a>
					@endif
				@elseif($trustee_id == 3)
					@if($sanctionLetterData->is_approve3 == 0)<a class="btn btn-info accept-sanction3" data-id="{{ $sanctionLetterData->id }}" href="javascript:;"><i class="fa fa-check"></i></a>
					&nbsp;&nbsp;
					<a class="btn btn-danger reject-sanction3" data-id="{{ $sanctionLetterData->id }}" href="javascript:;"><i class="fa fa-times"></i></a>
					@endif
				@endif
			</td>
		</tr>
	</table>
@endif

<script>
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

	// Reject
	$('.reject-sanction1').bind('click', function() {
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
					url: base_url+'rejectSanctionLetter1',
					type: 'post',
					data: {_token: CSRF_TOKEN, sanction_id: sanction_id},
					beforeSend: function() {
						var content = $('.preloader_doc').html();
					},
					success: function(output) {
						$('.accept-sanction-container'+sanction_id).addClass('d-none');

						Swal.fire({
							title: 'Rejected',
							title: 'Your file has been rejected.',
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

	$('.reject-sanction2').bind('click', function() {
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
					url: base_url+'rejectSanctionLetter2',
					type: 'post',
					data: {_token: CSRF_TOKEN, sanction_id: sanction_id},
					beforeSend: function() {
						var content = $('.preloader_doc').html();
					},
					success: function(output) {
						$('.accept-sanction-container'+sanction_id).addClass('d-none');

						Swal.fire({
							title: 'Rejected',
							title: 'Your file has been reject.',
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

	$('.reject-sanction3').bind('click', function() {
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
					url: base_url+'rejectSanctionLetter3',
					type: 'post',
					data: {_token: CSRF_TOKEN, sanction_id: sanction_id},
					beforeSend: function() {
						var content = $('.preloader_doc').html();
					},
					success: function(output) {
						$('.accept-sanction-container'+sanction_id).addClass('d-none');

						Swal.fire({
							title: 'Rejected',
							title: 'Your file has been rejected.',
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