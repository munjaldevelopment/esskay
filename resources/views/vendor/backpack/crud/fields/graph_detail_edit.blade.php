<?php
	$incomingType = array();
	
	
	$invoiceInfoArr = array();
	
	$bankData = \DB::table('analytics_graph_details')->where('analytics_graph_id', $entry->getKey())->orderBy('id', 'ASC')->get();
	if($bankData)
	{
		foreach($bankData as $row)
		{
			$invoiceInfoArr[] = array('graph_heading' => $row->graph_heading, 'graph_category' => $row->graph_category, 'graph_value' => $row->graph_value, 'graph_heading1' => $row->graph_heading1, 'graph_category1' => $row->graph_category1, 'graph_value1' => $row->graph_value1,
			'graph_heading2' => $row->graph_heading2, 'graph_category2' => $row->graph_category2, 'graph_value2' => $row->graph_value2);
		}
	}
	
	for($count=0;$count<=9;$count++)
	{
?>
<!-- select2 from array -->
<div class="form-group col-sm-4">
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