@php
    $total = 0;
    $cart = session('cart', []);
    foreach($cart as $id => $details) {
        $total += $details['price'] * $details['quantity'];
    }
@endphp

<div x-data="{ 
    open: false,
    cart: {{ json_encode($cart) }},
    total: {{ $total }},
    updateQuantity(id, quantity) {
        fetch('{{ route('cart.update') }}', {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ id: id, quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                location.reload(); 
            }
        });
    },
    removeFromCart(id) {
        fetch('{{ route('cart.remove') }}', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ id: id })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                location.reload();
            }
        });
    }
}" class="relative">
    
    <!-- Cart Button -->
    <button @click="open = !open" class="relative p-2 text-gray-600 hover:text-orange-600 transition-colors">
        <span class="text-2xl">🛒</span>
        @if(count($cart) > 0)
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                {{ count($cart) }}
            </span>
        @endif
    </button>

    <!-- Dropdown -->
    <div x-show="open" 
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-1"
         class="absolute right-0 mt-2 w-96 bg-white/90 backdrop-blur-md rounded-xl shadow-2xl border border-white/20 z-50 overflow-hidden"
         style="display: none;">
        
        <div class="p-4 bg-gradient-to-r from-orange-50 to-amber-50 border-b border-orange-100 flex justify-between items-center">
            <h3 class="font-bold text-gray-800">Tu Carrito</h3>
            <span class="text-sm text-gray-500">{{ count($cart) }} items</span>
        </div>

        <div class="max-h-96 overflow-y-auto p-4 space-y-4">
            @if(count($cart) > 0)
                @foreach($cart as $id => $details)
                    <div class="flex gap-4 items-start pb-4 border-b border-gray-100 last:border-0 last:pb-0">
                        <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <span class="text-2xl">📦</span>
                        </div>
                        
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-800 text-sm mb-1">{{ $details['name'] }}</h4>
                            <p class="text-xs text-gray-500 mb-2">
                                ${{ number_format($details['price'], 2) }} unit.
                            </p>
                            
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2 bg-gray-50 rounded-lg p-1">
                                    <button @click="updateQuantity({{ $id }}, {{ $details['quantity'] - 1 }})" 
                                            class="w-6 h-6 flex items-center justify-center text-gray-500 hover:bg-white hover:shadow-sm rounded transition-all text-xs"
                                            {{ $details['quantity'] <= 1 ? 'disabled' : '' }}>
                                        -
                                    </button>
                                    <span class="text-xs font-medium w-4 text-center">{{ $details['quantity'] }}</span>
                                    <button @click="updateQuantity({{ $id }}, {{ $details['quantity'] + 1 }})" 
                                            class="w-6 h-6 flex items-center justify-center text-gray-500 hover:bg-white hover:shadow-sm rounded transition-all text-xs">
                                        +
                                    </button>
                                </div>
                                
                                <button @click="removeFromCart({{ $id }})" class="text-red-400 hover:text-red-600 text-xs transition-colors">
                                    Eliminar
                                </button>
                            </div>
                        </div>
                        
                        <div class="text-right">
                            <p class="font-bold text-orange-600 text-sm">
                                ${{ number_format($details['price'] * $details['quantity'], 2) }}
                            </p>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-8">
                    <span class="text-4xl mb-2 block">🛒</span>
                    <p class="text-gray-500 text-sm">Tu carrito está vacío</p>
                </div>
            @endif
        </div>

        @if(count($cart) > 0)
            <div class="p-4 bg-gray-50 border-t border-gray-100">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-600 font-medium">Total</span>
                    <span class="text-xl font-bold text-gray-900">${{ number_format($total, 2) }}</span>
                </div>
                <a href="{{ route('cart.index') }}" class="block w-full bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white text-center py-3 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                    Proceder al Pago
                </a>
            </div>
        @endif
    </div>
</div>
