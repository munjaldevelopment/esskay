@if ($crud->hasAccess('checker_current_deal'))
	@if(($crud->hasAccess('checker_current_deal')) && ($entry->status != 1))
	<a href="javascript:void(0)" onclick="checkercurrentDealEntry(this)" data-route="{{ backpack_url('checkercurrentDeal/'.$entry->getKey()) }}" class="btn btn-sm btn-link" data-button-type="checkercurrentDeal"><i class="la la-check"></i> {{ trans('backpack::crud.approveTransaction') }}</a>
	@endif

	@if(($crud->hasAccess('checker_current_deal')) && ($entry->status != 2))
	<a href="javascript:void(0)" onclick="checkercurrentDealRejectEntry(this)" data-route="{{ backpack_url('checkercurrentDealReject/'.$entry->getKey()) }}" class="btn btn-sm btn-link" data-button-type="checkercurrentDeal"><i class="la la-times"></i> {{ trans('backpack::crud.rejectTransaction') }}</a>
	@endif
@endif

{{-- Button Javascript --}}
{{-- - used right away in AJAX operations (ex: List) --}}
{{-- - pushed to the end of the page, after jQuery is loaded, for non-AJAX operations (ex: Show) --}}
@push('after_scripts') @if (request()->ajax()) @endpush @endif
<script>
  	if (typeof checkercurrentDealRejectEntry != 'function') {
		$("[data-button-type=checkercurrentDeal]").unbind('click');

	  	function checkercurrentDealRejectEntry(button) {
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
							text: "{!! trans('backpack::crud.successTransaction') !!}"
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
								text: "{!! trans('backpack::crud.failureTransaction') !!}"
  							}).show();
		              	}
		          });
		        }
		});

      }
	}

	if (typeof checkercurrentDealEntry != 'function') {
	  	$("[data-button-type=checkercurrentDeal]").unbind('click');

	  	function checkercurrentDealEntry(button) {
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
		                    text: "{!! trans('backpack::crud.successTransaction') !!}"
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
		                    text: "{!! trans('backpack::crud.failureTransaction') !!}"
		                  }).show();
		              }
		          });
		        }
		});

      }
	}

	// make it so that the function above is run after each DataTable draw event
	// crud.addFunctionToDataTablesDrawEventQueue('checkercurrentDealEntry');
</script>
@if (!request()->ajax()) @endpush @endif