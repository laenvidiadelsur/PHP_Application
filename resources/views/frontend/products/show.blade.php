<x-frontend.layouts.app pageTitle="{{ $producto->name }}">
    <div class="container px-6 md:px-8 mx-auto max-w-6xl py-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Product Image -->
            <div>
                <div class="bg-gradient-to-br from-orange-100 to-amber-100 rounded-2xl overflow-hidden flex items-center justify-center h-96">
                    @if($producto->image_url)
                        <img src="{{ asset('storage/' . $producto->image_url) }}" 
                             alt="{{ $producto->name }}" 
                             class="w-full h-full object-cover">
                    @else
                    <span class="text-8xl">📦</span>
                    @endif
                </div>
            </div>
            
            <!-- Product Info -->
            <div>
                <div class="mb-4">
                    @if($producto->category)
                        <span class="px-3 py-1 bg-orange-100 text-orange-800 rounded-full text-sm font-medium">
                            {{ $producto->category->name }}
                        </span>
                    @endif
                </div>
                
                <h1 class="text-4xl font-bold mb-4">{{ $producto->name }}</h1>
                
                @if($producto->description)
                    <p class="text-gray-600 mb-6 leading-relaxed">{{ $producto->description }}</p>
                @endif
                
                <div class="mb-6">
                    <div class="text-4xl font-bold text-orange-600 mb-2">
                        Bs {{ number_format($producto->price, 2) }}
                    </div>
                    <div class="text-sm text-gray-500">
                        Stock disponible: <span class="font-medium {{ $producto->stock < 10 ? 'text-red-600' : 'text-green-600' }}">{{ $producto->stock }} unidades</span>
                    </div>
                </div>
                
                @if($producto->supplier)
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <div class="text-sm text-gray-600 mb-1">Proveedor:</div>
                        <div class="font-medium">{{ $producto->supplier->name }}</div>
                    </div>
                @endif
                
                @auth
                    @if($producto->estado === 'activo' && $producto->stock > 0)
                        <form action="{{ route('cart.add', $producto) }}" method="POST" class="mb-6">
                            @csrf
                            <div class="flex items-center gap-4">
                                <input type="number" name="quantity" value="1" min="1" max="{{ $producto->stock }}" 
                                       class="w-20 px-4 py-3 border border-gray-300 rounded-lg text-center">
                                <x-frontend.button type="submit" size="lg" class="flex-1">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Agregar al Carrito
                                </x-frontend.button>
                            </div>
                        </form>
                    @else
                        <div class="mb-6 p-4 bg-gray-100 rounded-lg text-center">
                            <p class="text-gray-600">Producto no disponible</p>
                        </div>
                    @endif
                @else
                    <div class="mb-6 p-4 bg-orange-50 rounded-lg text-center">
                        <p class="text-gray-700 mb-2">Inicia sesión para agregar productos al carrito</p>
                        <a href="{{ route('login') }}" class="text-orange-600 hover:text-orange-700 font-medium">
                            Iniciar Sesión →
                        </a>
                    </div>
                @endauth
                
                <div class="border-t pt-6">
                    <h3 class="font-bold mb-4">Información del Producto</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Estado:</span>
                            <span class="font-medium">
                                <span class="px-2 py-1 rounded {{ $producto->estado === 'activo' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($producto->estado) }}
                                </span>
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Stock:</span>
                            <span class="font-medium">{{ $producto->stock }} unidades</span>
                        </div>
                        @if($producto->supplier)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Proveedor:</span>
                                <span class="font-medium">{{ $producto->supplier->name }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-frontend.layouts.app>
