@if ($crud->hasAccess('checker_transaction_document'))
	@if($entry->document_status == 0 || $entry->document_status == 2)
	<a href="javascript:void(0)" onclick="checkertransDocumentEntry(this)" data-route="{{ backpack_url('checkerTransactionDocument/'.$entry->getKey()) }}" class="btn btn-sm btn-link" data-button-type="checkerDocument"><i class="la la-check"></i> {{ trans('backpack::crud.checkerDocument') }}</a>
	@endif

	@if($entry->document_status == 0)
  	<a href="javascript:void(0)" onclick="checkerTransactionRejectEntry(this)" data-route="{{ backpack_url('checkerTransactionDocumentReject/'.$entry->getKey()) }}" class="btn btn-sm btn-link" data-button-type="checkerDocument"><i class="la la-times"></i> {{ trans('backpack::crud.rejectTransaction') }}</a>
  	@endif
@endif

{{-- Button Javascript --}}
{{-- - used right away in AJAX operations (ex: List) --}}
{{-- - pushed to the end of the page, after jQuery is loaded, for non-AJAX operations (ex: Show) --}}
@push('after_scripts') @if (request()->ajax()) @endpush @endif
<script>
  	if (typeof checkerTransactionRejectEntry != 'function') {
		$("[data-button-type=checkerDocument]").unbind('click');

	  	function checkerTransactionRejectEntry(button) {
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

	if (typeof checkertransDocumentEntry != 'function') {
	  	$("[data-button-type=checkerDocument]").unbind('click');

	  	function checkertransDocumentEntry(button) {
	    	// ask for confirmation before deleting an item
	      	// e.preventDefault();
	      	var button = $(button);
	      	var route = button.attr('data-route');

	      	swal({
				title: "{!! trans('backpack::base.success') !!}",
				text: "{!! trans('backpack::crud.approve_confirm') !!}",
				icon: "success",
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
	// crud.addFunctionToDataTablesDrawEventQueue('checkertransDocumentEntry');
</script>
@if (!request()->ajax()) @endpush @endif