<x-frontend.layouts.app pageTitle="Orden Confirmada">
    <div class="container px-6 md:px-8 mx-auto max-w-4xl py-12">
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-gradient-to-r from-emerald-500 to-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h1 class="text-4xl font-bold mb-4">
                <span class="bg-gradient-to-r from-emerald-600 to-green-600 bg-clip-text text-transparent">
                    ¡Orden Confirmada!
                </span>
            </h1>
            <p class="text-xl text-gray-600">
                Tu orden ha sido procesada exitosamente
            </p>
        </div>
        
        <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
            <div class="mb-6">
                <h2 class="text-2xl font-bold mb-4">Detalles de la Orden</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <span class="text-gray-600">Número de Orden:</span>
                        <span class="font-bold ml-2">#{{ $orden->id }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Estado:</span>
                        <span class="ml-2 px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">
                            {{ ucfirst($orden->estado) }}
                        </span>
                    </div>
                    <div>
                        <span class="text-gray-600">Total:</span>
                        <span class="font-bold text-orange-600 ml-2 text-xl">${{ number_format($orden->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>
            
            @if($orden->cart && $orden->cart->items)
                <div class="border-t pt-6">
                    <h3 class="text-lg font-bold mb-4">Productos</h3>
                    <div class="space-y-3">
                        @foreach($orden->cart->items as $item)
                            <div class="flex justify-between items-center py-3 border-b">
                                <div>
                                    <div class="font-medium">{{ $item->product->name }}</div>
                                    <div class="text-sm text-gray-500">Cantidad: {{ $item->quantity }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="font-medium">${{ number_format($item->product->price * $item->quantity, 2) }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <x-frontend.button href="{{ route('home') }}" size="lg">
                Volver al Inicio
            </x-frontend.button>
            @if(Route::has('orders.index'))
                <x-frontend.button href="{{ route('orders.index') }}" variant="outline" size="lg">
                    Ver Mis Pedidos
                </x-frontend.button>
            @endif
        </div>
    </div>
</x-frontend.layouts.app>

