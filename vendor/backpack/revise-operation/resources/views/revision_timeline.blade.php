@php
	$count = 0;
@endphp
<div id="timeline">
@foreach($revisions as $revisionDate => $dateRevisions)
      <h5 class="text-primary">
        {{ Carbon\Carbon::parse($revisionDate)->isoFormat(config('backpack.base.default_date_format')) }}
      </h5>

  @foreach($dateRevisions as $history)
	@if($history->fieldName() == "document_status" || $history->fieldName() == "lender_banking_status" || $history->fieldName() == "is_document" || $history->fieldName() == "is_message_md" || $history->fieldName() == "is_banking_arrangement" || $history->fieldName() == "is_contact_us" || $history->fieldName() == "is_newsletter" || $history->fieldName() == "is_financial_summary")
	
	@else
		<div class="card timeline-item-wrap @if($count > 0) disable-card @endif">
		  @if($history->key == 'created_at' && !$history->old_value)
			<div class="card-header">
			  <strong class="time"><i class="la la-clock"></i> {{ date('h:ia', strtotime($history->created_at)) }}</strong> -
			  {{ $history->userResponsible()?$history->userResponsible()->name:trans('revise-operation::revise.guest_user') }} {{ trans('revise-operation::revise.created_this') }} {{ $crud->entity_name }}
			</div>
		  @else
			<div class="card-header">
			  <strong class="time"><i class="la la-clock"></i> {{ date('h:ia', strtotime($history->created_at)) }}</strong> -
			  {{ $history->userResponsible()?$history->userResponsible()->name:trans('revise-operation::revise.guest_user') }} {{ trans('revise-operation::revise.changed_the') }} {{ str_replace("_", " ", ucfirst($history->fieldName())) }}
			  <div class="card-header-actions">
				@if($count == 0)
				@if($crud->entity_name == "document")
					@if ($crud->hasAccess('checker_document') && $entry->document_status == 0)
						<div class="card-header-action">
							<a href="javascript:void(0)" onclick="checkerDocumentEntryTimeline(this)" data-route="{{ backpack_url('checkerDocument/'.$entry->getKey()) }}" class="btn btn-outline-success btn-sm" data-button-type="checkerDocument"><i class="la la-copy"></i> {{ trans('backpack::crud.checkerDocument') }}</a>
						</div>
					@endif
				@endif
				
				<form class="card-header-action" method="post" action="{{ url(\Request::url().'/'.$history->id.'/restore') }}">
				  {!! csrf_field() !!}
				  <button type="submit" class="btn btn-outline-danger btn-sm restore-btn" data-entry-id="{{ $entry->id }}" data-revision-id="{{ $history->id }}" onclick="onRestoreClick(event)">
					<i class="la la-undo"></i> {{ trans('revise-operation::revise.reject') }}</button>
				  </form>
				  @endif
			  </div>
			</div>
			<div class="card-body">
			  <div class="row">
				<div class="col-md-6">{{ mb_ucfirst(trans('revise-operation::revise.from')) }}:</div>
				<div class="col-md-6">{{ mb_ucfirst(trans('revise-operation::revise.to')) }}:</div>
			  </div>
			  <div class="row">
				<div class="col-md-6"><div class="alert alert-danger" style="overflow: hidden;">
					@if($history->fieldName() == "document_status" || $history->fieldName() == "lender_banking_status")
						@if($history->oldValue() == "0")
							No
						@elseif($history->oldValue() == "1")
							Yes
						@else
							{{ $history->oldValue() }}
						@endif
					@elseif($history->fieldName() == "document_filename")
						<a target="_blank" href="{{ asset('/').$history->oldValue() }}">{{ $history->oldValue() }}</a>
					@else
						{{ $history->oldValue() }}
					@endif
				</div></div>
				<div class="col-md-6"><div class="alert alert-success" style="overflow: hidden;">
					@if($history->fieldName() == "document_status" || $history->fieldName() == "lender_banking_status")
						@if($history->newValue() == "0")
							No
						@elseif($history->newValue() == "1")
							Yes
						@else
							{{ $history->newValue() }}
						@endif
					@elseif($history->fieldName() == "document_filename")
						<a target="_blank" href="{{ asset('/').$history->newValue() }}">{{ $history->newValue() }}</a>
					@else
						{{ $history->newValue() }}
					@endif
				</div></div>
			  </div>
			</div>
		  @endif
		</div>
		
		@php
			$count++;
		@endphp
	@endif

  @endforeach
@endforeach
</div>

@section('after_scripts')
<script>
	if (typeof checkerDocumentEntryTimeline != 'function') {
	  $("[data-button-type=checkerDocument]").unbind('click');

	  function checkerDocumentEntryTimeline(button) {
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

                  setTimeout(function() {
					location = '{{ url($crud->route) }}';
				  }, 2000);
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
	// crud.addFunctionToDataTablesDrawEventQueue('checkerDocumentEntryTimeline');
</script>

  <script type="text/javascript">
    $.ajaxPrefilter(function(options, originalOptions, xhr) {
        var token = $('meta[name="csrf_token"]').attr('content');

        if (token) {
              return xhr.setRequestHeader('X-XSRF-TOKEN', token);
        }
    });
    function onRestoreClick(e) {
      e.preventDefault();
      var entryId = $(e.target).attr('data-entry-id');
      var revisionId = $(e.target).attr('data-revision-id');
      $.ajax('{{ url(\Request::url()).'/' }}' +  revisionId + '/restore', {
        method: 'POST',
        data: {
          revision_id: revisionId
        },
        success: function(revisionTimeline) {
          // Replace the revision list with the updated revision list
          $('#timeline').replaceWith(revisionTimeline);

          // Animate the new revision in (by sliding)
          $('.timeline-item-wrap').first().addClass('fadein');

          // Show a green notification bubble
          new Noty({
              type: "success",
              text: "{{ trans('revise-operation::revise.revision_restored') }}"
          }).show();
		  
		  setTimeout(function() {
			location = '{{ url($crud->route) }}';
		  }, 2000);
        },
        error: function(data) {
          // Show a red notification bubble
          new Noty({
              type: "error",
              text: data.responseJSON.message
          }).show();
        }
      });
  }
  </script>
@endsection

@section('after_styles')
  {{-- Animations for new revisions after ajax calls --}}
  <style>
     .timeline-item-wrap.fadein {
      -webkit-animation: restore-fade-in 3s;
              animation: restore-fade-in 3s;
    }
    @-webkit-keyframes restore-fade-in {
      from {opacity: 0}
      to {opacity: 1}
    }
      @keyframes restore-fade-in {
        from {opacity: 0}
        to {opacity: 1}
    }
  </style>
@endsection
