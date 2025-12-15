<x-frontend.layouts.app pageTitle="Carrito de Compras">
    <div class="container px-6 md:px-8 mx-auto max-w-6xl py-12">
        <h1 class="text-4xl font-bold mb-8">
            <span class="bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
                Carrito de Compras
            </span>
        </h1>
        
        @if(!empty($errors))
            <div class="mb-6 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach($errors as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif
        
        @if(count($items) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Items List -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <div class="space-y-4">
                            @foreach($items as $item)
                                <div class="flex items-center gap-4 pb-4 border-b last:border-0">
                                    <div class="w-20 h-20 bg-gradient-to-br from-orange-100 to-amber-100 rounded-lg flex items-center justify-center overflow-hidden">
                                        @if($item['producto']->image_url)
                                            <img src="{{ asset('storage/' . $item['producto']->image_url) }}" 
                                                 alt="{{ $item['producto']->name }}" 
                                                 class="w-full h-full object-cover">
                                        @else
                                        <span class="text-3xl">📦</span>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-bold">{{ $item['producto']->name }}</h3>
                                        <p class="text-sm text-gray-600">Bs {{ number_format($item['price'], 2) }} c/u</p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            Stock disponible: <span class="font-medium {{ $item['producto']->stock < 10 ? 'text-red-600' : 'text-green-600' }}">{{ $item['producto']->stock }}</span>
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-bold text-lg mb-2">Bs {{ number_format($item['total'], 2) }}</div>
                                        <div class="flex items-center gap-2">
                                            <input type="number" 
                                                   value="{{ $item['quantity'] }}" 
                                                   min="1" 
                                                   max="{{ $item['producto']->stock }}"
                                                   data-product-id="{{ $item['id'] }}"
                                                   class="w-16 px-2 py-1 border border-gray-300 rounded text-center cart-quantity">
                                            <button type="button" 
                                                    data-product-id="{{ $item['id'] }}"
                                                    class="text-red-600 hover:text-red-800 cart-remove">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-lg p-6 sticky top-24">
                        <h2 class="text-xl font-bold mb-4">Resumen</h2>
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal:</span>
                                <span class="font-medium">Bs {{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Impuestos (15%):</span>
                                <span class="font-medium">Bs {{ number_format($tax, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-xl font-bold pt-3 border-t">
                                <span>Total:</span>
                                <span class="text-orange-600">Bs {{ number_format($total, 2) }}</span>
                            </div>
                        </div>
                        <a href="{{ route('checkout.index') }}" class="block w-full bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-300 text-center shadow-lg hover:shadow-xl">
                            Proceder al Checkout
                        </a>
                        <a href="{{ route('products.index') }}" class="block w-full mt-3 text-center text-gray-600 hover:text-orange-600 transition-colors">
                            Continuar Comprando
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-12 bg-white rounded-lg shadow-lg">
                <svg class="w-24 h-24 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h2 class="text-2xl font-bold mb-2">Tu carrito está vacío</h2>
                <p class="text-gray-600 mb-6">Agrega productos para comenzar</p>
                <x-frontend.button href="{{ route('products.index') }}" size="lg">
                    Ver Productos
                </x-frontend.button>
            </div>
        @endif
    </div>
    
    @push('scripts')
    <script>
        // Update quantity
        document.querySelectorAll('.cart-quantity').forEach(input => {
            input.addEventListener('change', function() {
                const productId = this.dataset.productId;
                const quantity = parseInt(this.value);
                
                if (quantity < 1) {
                    this.value = 1;
                    return;
                }
                
                fetch('{{ route("cart.update") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        id: productId,
                        quantity: quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message || 'Error al actualizar');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al actualizar el carrito');
                });
            });
        });
        
        // Remove item
        document.querySelectorAll('.cart-remove').forEach(button => {
            button.addEventListener('click', function() {
                if (!confirm('¿Estás seguro de eliminar este producto del carrito?')) {
                    return;
                }
                
                const productId = this.dataset.productId;
                
                fetch('{{ route("cart.remove") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        id: productId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al eliminar el producto');
                });
            });
        });
    </script>
    @endpush
</x-frontend.layouts.app>

