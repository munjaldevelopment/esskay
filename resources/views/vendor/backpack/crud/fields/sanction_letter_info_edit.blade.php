<?php
	$sanction_letter_id = $entry->getKey();
	$invoiceInfo = \DB::table('sanction_letter_info')->where('sanction_letter_id', $sanction_letter_id)->get();
	
	$invoiceInfoArr = array();
	if($invoiceInfo)
	{
		foreach($invoiceInfo as $k => $row)
		{
			$invoiceInfoArr[$k+1] = array('sanction_letter_field' => $row->sanction_letter_field, 'sanction_letter_value' => $row->sanction_letter_value, 'sanction_letter_id' => $sanction_letter_id, 'sanction_letter_info_id' => $row->id);
		}
	}
	
	$next_count = count($invoiceInfoArr) + 1;
	
	if($invoiceInfoArr)
	{
		foreach($invoiceInfoArr as $k => $invoiceInfoRow)
		{
?>
<div class="pump_container_{{ $k }}">
	<div @include('crud::inc.field_wrapper_attributes') >
		<label>{!! $field['label'] !!}</label>
		<input
				type="text"
				name="{{ $field['name'] }}[]"
				value="{{ $invoiceInfoRow['sanction_letter_field'] }}"
				style="width: 100%"
				@include('crud::inc.field_attributes')
			>
		
		<label>{!! $field['label'] !!} Value</label>
		<input
				type="text"
				name="{{ $field['name'] }}_value[]"
				value="{{ $invoiceInfoRow['sanction_letter_value'] }}"
				id="invoice_info_quantity_{{ $k }}"
				@include('crud::inc.field_attributes')
			>
			
		<div id="pump_quantity_container{{ $k }}"></div>
			
		{{-- HINT --}}
		@if (isset($field['hint']))
			<p class="help-block">{!! $field['hint'] !!}</p>
		@endif
	</div>
</div>
<?php
		}
	}
?>

<!-- select2 from array -->
<div class="pump_container_{{ $next_count }}">
	<div @include('crud::inc.field_wrapper_attributes') >
		<label>{!! $field['label'] !!}</label>
		<input
				type="text"
				name="{{ $field['name'] }}[]"
				style="width: 100%"
				id="pump_id{{ $next_count }}"
				@include('crud::inc.field_attributes')
			>
		
		<label>{!! $field['label'] !!} Value</label>
		<input
				type="text"
				name="{{ $field['name'] }}_value[]"
				value=""
				id="invoice_info_quantity_{{ $next_count }}"
				@include('crud::inc.field_attributes')
			>
			
		<div id="pump_quantity_container{{ $next_count }}"></div>
		
		<i class="fa fa-plus btn btn-info pull-right" onclick="addNextPump({{ $next_count + 1 }});"></i>
			
		{{-- HINT --}}
		@if (isset($field['hint']))
			<p class="help-block">{!! $field['hint'] !!}</p>
		@endif
	</div>
</div>

<div class="pump_output_container"></div>

<style>
	.cross-box {
		float: right;
		position: absolute;
		right: 0;
		top: 0;
		cursor: pointer;
	}
</style>


{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field))

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
    <!-- include select2 css-->
    <link href="{{ asset('vendor/adminlte/bower_components/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="https://select2.github.io/select2-bootstrap-theme/css/select2-bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
    <!-- include select2 js-->
    <script src="{{ asset('vendor/adminlte/bower_components/select2/dist/js/select2.min.js') }}"></script>
    <script>
        jQuery(document).ready(function($) {
            // trigger select2 for each untriggered select2 box
            $('.select2_from_array').each(function (i, obj) {
                if (!$(obj).hasClass("select2-hidden-accessible"))
                {
                    $(obj).select2({
                        theme: "bootstrap"
                    });
                }
            });
        });
		
		function getPumpEditQuantity(sanction_letter_id, sanction_letter_info_id, pump_id, quantity, pump_count)
		{
			$.ajax({
				type:"GET",
				url:"{{ backpack_url('getEditPumpUserInfo') }}/"+sanction_letter_id+"/"+sanction_letter_info_id+"/"+pump_id+"/"+quantity+"/"+pump_count,
				success:function(result){
					$('#pump_quantity_container'+pump_count).html(result);
				}
			});
		}
		
		<?php
			if($invoiceInfoArr)
			{
				foreach($invoiceInfoArr as $k => $invoiceInfoRow)
				{
		?>
		getPumpEditQuantity('{{ $invoiceInfoRow['sanction_letter_id'] }}', '{{ $invoiceInfoRow['sanction_letter_info_id'] }}', '{{ $invoiceInfoRow['pump_id'] }}', '{{ $invoiceInfoRow['quantity'] }}', '{{ $k }}');
		<?php
				}
			}
		?>
    </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
