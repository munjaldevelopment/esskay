<!-- select2 from array -->
<div class="pump_container_{{ $count }}">
	<div @include('crud::inc.field_wrapper_attributes') >
		<label>{!! $label !!}</label>
		<input
				type="text"
				name="{{ $field['name'] }}[]"
				value=""
				style="width: 100%"
				@include('crud::inc.field_attributes')
			>
		
		<label>{!! $field['label'] !!} Quantity #</label>
		<input
				type="text"
				name="{{ $field['name'] }}_value[]"
				value=""
				id="invoice_info_quantity_{{ $count }}"
				@include('crud::inc.field_attributes')
			>
			
		<div id="pump_quantity_container{{ $count }}"></div>
		
		<i class="fa fa-plus btn btn-info pull-right" onclick="addNextPump({{ $count }});"></i>
		<i class="fa fa-times btn btn-info pull-right" onclick="removePumpContainer({{ $count }});"></i>
	</div>
</div>

<style>
	.cross-box {
		float: right;
		position: absolute;
		right: 0;
		top: 0;
		cursor: pointer;
	}
</style>