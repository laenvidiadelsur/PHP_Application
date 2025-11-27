@props(['hover' => true])

<div {{ $attributes->merge(['class' => 'group overflow-hidden border-0 shadow-lg ' . ($hover ? 'hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2' : '') . ' bg-white rounded-lg']) }}>
    @if(isset($header))
        <div class="p-6 border-b border-gray-200">
            {{ $header }}
        </div>
    @endif
    
    <div class="p-6">
        {{ $slot }}
    </div>
    
    @if(isset($footer))
        <div class="p-6 border-t border-gray-200 bg-gray-50">
            {{ $footer }}
        </div>
    @endif
</div>

