<?php
	$incomingType = array();
	
	
	$invoiceInfoArr = array();	
	
	for($count=1;$count<=10;$count++)
	{
?>
<div class="form-group col-sm-2">
    <label>{!! $field['label'] !!} Heading</label>
	
	<input
            type="text"
			class="form-control"
            name="{{ $field['name'] }}_graph_heading[]"
            value="@if(isset($invoiceInfoArr[$count])){{$invoiceInfoArr[$count]['graph_heading']}}@endif"
        >
</div>

<div class="form-group col-sm-4">
    <label>{!! $field['label'] !!} Cat</label>
	
	<input
            type="hidden"
            name="analytics_graph_id[]"
            value="{{ $count }}"
        >
	<input
            type="text"
			class="form-control"
            name="{{ $field['name'] }}_graph_category[]"
            value="@if(isset($invoiceInfoArr[$count])){{$invoiceInfoArr[$count]['graph_category']}}@endif"
        >
</div>

<div class="form-group col-sm-4">
	<label>{!! $field['label'] !!} Value</label>
	<input
            type="text"
			class="form-control"
            name="{{ $field['name'] }}_graph_value[]"
            value="@if(isset($invoiceInfoArr[$count])){{$invoiceInfoArr[$count]['graph_value']}}@endif"
        >
	
    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>

<div class="form-group col-sm-4">
    <label>{!! $field['label'] !!} Heading1</label>
	
	<input
            type="text"
			class="form-control"
            name="{{ $field['name'] }}_graph_heading1[]"
            value="@if(isset($invoiceInfoArr[$count])){{$invoiceInfoArr[$count]['graph_heading1']}}@endif"
        >
</div>

<div class="form-group col-sm-4">
    <label>{!! $field['label'] !!} Cat1</label>
	
		
	<input
            type="text"
			class="form-control"
            name="{{ $field['name'] }}_graph_category1[]"
            value="@if(isset($invoiceInfoArr[$count])){{$invoiceInfoArr[$count]['graph_category1']}}@endif"
        >
</div>

<div class="form-group col-sm-4">
	<label>{!! $field['label'] !!} Value1</label>
	<input
            type="text"
			class="form-control"
            name="{{ $field['name'] }}_graph_value1[]"
            value="@if(isset($invoiceInfoArr[$count])){{$invoiceInfoArr[$count]['graph_value1']}}@endif"
        >
	
    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>

<div class="form-group col-sm-4">
    <label>{!! $field['label'] !!} Heading2</label>
	
	<input
            type="text"
			class="form-control"
            name="{{ $field['name'] }}_graph_heading2[]"
            value="@if(isset($invoiceInfoArr[$count])){{$invoiceInfoArr[$count]['graph_heading2']}}@endif"
        >
</div>

<div class="form-group col-sm-4">
    <label>{!! $field['label'] !!} Cat2</label>
	
		
	<input
            type="text"
			class="form-control"
            name="{{ $field['name'] }}_graph_category2[]"
            value="@if(isset($invoiceInfoArr[$count])){{$invoiceInfoArr[$count]['graph_category2']}}@endif"
        >
</div>

<div class="form-group col-sm-4" style="border-right:1px red solid;">
	<label>{!! $field['label'] !!} Value2</label>
	<input
            type="text"
			class="form-control"
            name="{{ $field['name'] }}_graph_value2[]"
            value="@if(isset($invoiceInfoArr[$count])){{$invoiceInfoArr[$count]['graph_value2']}}@endif"
        >
	
    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>
<?php
	}
?>