{{-- regular object attribute --}}
@php
    $current_key = $entry->getKey();
    $value = "";
    $isExists = \DB::table($column['transaction_document_revisions'])->where($column['table_field'], $current_key)->orderBy('id', 'DESC')->first();

    if($isExists)
    {
        $value = $isExists->$column['field_show'];
    }

    $column['escaped'] = true;
    $column['limit'] = $column['limit'];
    $column['prefix'] = '';
    $column['suffix'] = '';
    $column['text'] = $column['prefix'].Str::limit($value, $column['limit'], '[...]').$column['suffix'];
@endphp

<span>
    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_start')
        @if($column['escaped'])
            <a target="_blank" href="{{ asset('/').$column['text'] }}">{{ $column['text'] }}</a>
        @else
            <a target="_blank" href="{{ asset('/').$column['text'] }}">{!! $column['text'] !!}</a>
        @endif
    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_end')
</span>
