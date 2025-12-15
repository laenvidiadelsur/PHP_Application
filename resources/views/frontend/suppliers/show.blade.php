<x-frontend.layouts.app :pageTitle="$proveedor->name">
    <div class="container px-6 md:px-8 mx-auto max-w-7xl py-12">
        <!-- Supplier Details -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 mb-12">
            <div class="flex flex-col md:flex-row gap-8 items-start">
                <div class="w-full md:w-1/3">
                    <div class="aspect-square bg-gradient-to-br from-blue-100 to-indigo-100 rounded-xl flex items-center justify-center overflow-hidden">
                        @if($proveedor->image_url)
                            <img src="{{ asset('storage/' . $proveedor->image_url) }}"
                                 alt="{{ $proveedor->name }}"
                                 class="w-full h-full object-cover">
                        @else
                            <span class="text-8xl">🏪</span>
                        @endif
                    </div>
                </div>
                <div class="w-full md:w-2/3">
                    <div class="flex items-center gap-3 mb-4">
                        <h1 class="text-4xl font-bold text-gray-900">{{ $proveedor->name }}</h1>
                        @if($proveedor->activo)
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full text-sm font-medium">
                                ✓ Activo
                            </span>
                        @endif
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600 mb-6">
                        @if($proveedor->contact_name)
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span><strong>Contacto:</strong> {{ $proveedor->contact_name }}</span>
                            </div>
                        @endif
                        
                        @if($proveedor->email)
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <a href="mailto:{{ $proveedor->email }}" class="text-blue-600 hover:text-blue-700">{{ $proveedor->email }}</a>
                            </div>
                        @endif
                        
                        @if($proveedor->phone)
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <a href="tel:{{ $proveedor->phone }}" class="text-blue-600 hover:text-blue-700">{{ $proveedor->phone }}</a>
                            </div>
                        @endif
                        
                        @if($proveedor->address)
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $proveedor->address }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Section -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Productos del Proveedor</h2>
        </div>

        @if($proveedor->productos->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($proveedor->productos as $product)
                    <x-frontend.card>
                        <div class="relative group">
                            <div class="w-full h-48 bg-gray-100 rounded-lg mb-4 flex items-center justify-center overflow-hidden">
                                @if($product->image_url)
                                    <img src="{{ asset('storage/' . $product->image_url) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                @else
                                <span class="text-4xl group-hover:scale-110 transition-transform duration-300">📦</span>
                                @endif
                            </div>
                            
                            <div class="mb-4">
                                <p class="text-xs text-orange-600 font-medium mb-1">{{ $product->category->name ?? 'Sin categoría' }}</p>
                                <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $product->name }}</h3>
                                <p class="text-xl font-bold text-gray-900">Bs {{ number_format($product->price, 2) }}</p>
                            </div>

                            <div class="flex flex-col gap-2">
                                <a href="{{ route('products.show', $product) }}" 
                                   class="w-full bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 hover:text-gray-900 px-4 py-2 rounded-lg font-medium transition-colors text-center text-sm">
                                    Ver Detalles
                                </a>
                                <form action="{{ route('cart.add', $product) }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white px-4 py-2 rounded-lg font-medium transition-all duration-300 text-sm shadow-sm hover:shadow">
                                        Agregar al Carrito
                                    </button>
                                </form>
                            </div>
                        </div>
                    </x-frontend.card>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                <p class="text-gray-500">Este proveedor no tiene productos disponibles en este momento.</p>
            </div>
        @endif
    </div>
</x-frontend.layouts.app>
