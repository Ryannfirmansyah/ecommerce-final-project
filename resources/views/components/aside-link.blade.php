@props(['active'])

@php
$classes = ($active ?? false)
    ? 'flex items-center gap-3 px-4 py-3 rounded-2xl bg-gray-200 shadow-inner text-black font-bold transition-all'
    : 'flex items-center gap-3 px-4 py-3 rounded-2xl text-gray-600 hover:bg-gray-100 transition-all'
@endphp

<a {{$attributes->merge(['class' => $classes])}} >{{$slot}}
    
</a>