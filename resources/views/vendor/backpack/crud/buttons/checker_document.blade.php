@if ($crud->hasAccess('checker_document') && $entry->document_status == 0)
	<a href="javascript:void(0)" onclick="checkerDocumentEntry(this)" data-route="{{ backpack_url('checkerDocument/'.$entry->getKey()) }}" class="btn btn-sm btn-link" data-button-type="checkerDocument"><i class="la la-copy"></i> {{ trans('backpack::crud.checkerDocument') }}</a>
@endif

{{-- Button Javascript --}}
{{-- - used right away in AJAX operations (ex: List) --}}
{{-- - pushed to the end of the page, after jQuery is loaded, for non-AJAX operations (ex: Show) --}}
@push('after_scripts') @if (request()->ajax()) @endpush @endif
<script>
	if (typeof checkerDocumentEntry != 'function') {
	  $("[data-button-type=checkerDocument]").unbind('click');

	  function checkerDocumentEntry(button) {
	      // ask for confirmation before deleting an item
	      // e.preventDefault();
	      var button = $(button);
	      var route = button.attr('data-route');

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
	}

	// make it so that the function above is run after each DataTable draw event
	// crud.addFunctionToDataTablesDrawEventQueue('checkerDocumentEntry');
</script>
@if (!request()->ajax()) @endpush @endif