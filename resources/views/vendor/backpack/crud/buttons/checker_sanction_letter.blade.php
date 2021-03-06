@if (($crud->hasAccess('checker_sanction_letter1') || $crud->hasAccess('checker_sanction_letter2') || $crud->hasAccess('checker_sanction_letter3')))
	@if(($crud->hasAccess('checker_sanction_letter1')) && ($entry->is_approve1 != 1))
	<a href="javascript:void(0)" onclick="checkersanctionLetterEntry(this)" data-route="{{ backpack_url('checkerSanctionLetter/'.$entry->getKey()) }}" class="btn btn-sm btn-link" data-button-type="checkerDocument"><i class="la la-check"></i> {{ trans('backpack::crud.checkerSanctionLetter') }}</a>

	<a href="javascript:void(0)" onclick="checkerSanctionLetterRejectEntry(this)" data-route="{{ backpack_url('checkerSanctionLetterReject/'.$entry->getKey()) }}" class="btn btn-sm btn-link" data-button-type="checkerDocument"><i class="la la-times"></i> {{ trans('backpack::crud.rejectTransaction') }}</a>
	@endif

	@if(($crud->hasAccess('checker_sanction_letter2')) && ($entry->is_approve2 != 1))
	<a href="javascript:void(0)" onclick="checkersanctionLetterEntry(this)" data-route="{{ backpack_url('checkerSanctionLetter2/'.$entry->getKey()) }}" class="btn btn-sm btn-link" data-button-type="checkerDocument"><i class="la la-check"></i> {{ trans('backpack::crud.checkerSanctionLetter2') }}</a>

	<a href="javascript:void(0)" onclick="checkerSanctionLetterRejectEntry(this)" data-route="{{ backpack_url('checkerSanctionLetterReject2/'.$entry->getKey()) }}" class="btn btn-sm btn-link" data-button-type="checkerDocument"><i class="la la-times"></i> {{ trans('backpack::crud.rejectTransaction') }}</a>
	@endif

	@if(($crud->hasAccess('checker_sanction_letter3')) && ($entry->is_approve3 != 1))
	<a href="javascript:void(0)" onclick="checkersanctionLetterEntry(this)" data-route="{{ backpack_url('checkerSanctionLetter3/'.$entry->getKey()) }}" class="btn btn-sm btn-link" data-button-type="checkerDocument"><i class="la la-check"></i> {{ trans('backpack::crud.checkerSanctionLetter3') }}</a>

	<a href="javascript:void(0)" onclick="checkerSanctionLetterRejectEntry(this)" data-route="{{ backpack_url('checkerSanctionLetterReject3/'.$entry->getKey()) }}" class="btn btn-sm btn-link" data-button-type="checkerDocument"><i class="la la-times"></i> {{ trans('backpack::crud.rejectTransaction') }}</a>
	@endif
@endif

{{-- Button Javascript --}}
{{-- - used right away in AJAX operations (ex: List) --}}
{{-- - pushed to the end of the page, after jQuery is loaded, for non-AJAX operations (ex: Show) --}}
@push('after_scripts') @if (request()->ajax()) @endpush @endif
<script>
  	if (typeof checkerSanctionLetterRejectEntry != 'function') {
		$("[data-button-type=checkerDocument]").unbind('click');

	  	function checkerSanctionLetterRejectEntry(button) {
			// ask for confirmation before deleting an item
			// e.preventDefault();
			var button = $(button);
			var route = button.attr('data-route');

			swal({
				title: "{!! trans('backpack::base.warning') !!}",
				text: "{!! trans('backpack::crud.reject_confirm') !!}",
				icon: "warning",
				buttons: {
					cancel: {
				  text: "{!! trans('backpack::crud.cancel') !!}",
				  value: null,
				  visible: true,
				  className: "bg-secondary",
				  closeModal: true,
				},
				delete: {
				  text: "{!! trans('backpack::crud.confirm') !!}",
				  value: true,
				  visible: true,
				  className: "bg-danger",
				}
			},
	  		}).then((value) => {
				if (value) {
		          	$.ajax({
						url: route,
						type: 'POST',
						success: function(result) {
		                  // Show an alert with the result
		                  new Noty({
							type: "success",
							text: "{!! trans('backpack::crud.checkerDocument_success') !!}"
		                  }).show();

		                  // Hide the modal, if any
		                  $('.modal').modal('hide');

		                  if (typeof crud !== 'undefined') {
		                    crud.table.ajax.reload();
		                  }
		              	},
		              	error: function(result) {
							// Show an alert with the result
							new Noty({
								type: "warning",
								text: "{!! trans('backpack::crud.checkerDocument_failure') !!}"
  							}).show();
		              	}
		          });
		        }
		});

      }
	}

	if (typeof checkersanctionLetterEntry != 'function') {
	  	$("[data-button-type=checkerDocument]").unbind('click');

	  	function checkersanctionLetterEntry(button) {
	    	// ask for confirmation before deleting an item
	      	// e.preventDefault();
	      	var button = $(button);
	      	var route = button.attr('data-route');

	      	swal({
				title: "{!! trans('backpack::base.info') !!}",
				text: "{!! trans('backpack::crud.approve_confirm') !!}",
				icon: "info",
				buttons: {
					cancel: {
				  text: "{!! trans('backpack::crud.cancel') !!}",
				  value: null,
				  visible: true,
				  className: "bg-secondary",
				  closeModal: true,
				},
				delete: {
				  text: "{!! trans('backpack::crud.confirm') !!}",
				  value: true,
				  visible: true,
				  className: "bg-primary",
				}
			},
	  		}).then((value) => {
				if (value) {
		          $.ajax({
		              url: route,
		              type: 'POST',
		              success: function(result) {
		                  // Show an alert with the result
		                  new Noty({
		                    type: "success",
		                    text: "{!! trans('backpack::crud.checkerDocument_success') !!}"
		                  }).show();

		                  // Hide the modal, if any
		                  $('.modal').modal('hide');

		                  if (typeof crud !== 'undefined') {
		                    crud.table.ajax.reload();
		                  }
		              },
		              error: function(result) {
		                  // Show an alert with the result
		                  new Noty({
		                    type: "warning",
		                    text: "{!! trans('backpack::crud.checkerDocument_failure') !!}"
		                  }).show();
		              }
		          });
		        }
		});

      }
	}

	// make it so that the function above is run after each DataTable draw event
	// crud.addFunctionToDataTablesDrawEventQueue('checkersanctionLetterEntry');
</script>
@if (!request()->ajax()) @endpush @endif