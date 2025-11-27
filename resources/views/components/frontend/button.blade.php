@props([
    'variant' => 'default',
    'size' => 'default',
    'type' => 'button',
    'href' => null
])

@php
    $variants = [
        'default' => 'bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white shadow-lg hover:shadow-xl',
        'outline' => 'border-2 border-orange-600 text-orange-600 hover:bg-orange-600 hover:text-white',
        'secondary' => 'bg-gray-200 text-gray-800 hover:bg-gray-300',
        'ghost' => 'text-gray-700 hover:bg-gray-100',
        'destructive' => 'bg-red-600 text-white hover:bg-red-700',
    ];
    
    $sizes = [
        'sm' => 'px-4 py-2 text-sm',
        'default' => 'px-6 py-3 text-base',
        'lg' => 'px-8 py-4 text-lg',
    ];
    
    $classes = $variants[$variant] . ' ' . $sizes[$size] . ' rounded-lg font-medium transition-all duration-300';
@endphp

@if(isset($href))
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes . ' inline-block text-center']) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif

