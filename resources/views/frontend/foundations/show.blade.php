<x-frontend.layouts.app :pageTitle="$fundacion->name">
    <div class="container px-6 md:px-8 mx-auto max-w-7xl py-12">
        <!-- Foundation Details -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 mb-12">
            <div class="flex flex-col md:flex-row gap-8 items-start">
                <div class="w-full md:w-1/3">
                    <div class="aspect-square bg-gradient-to-br from-orange-100 to-amber-100 rounded-xl flex items-center justify-center overflow-hidden">
                        @if($fundacion->image_url)
                            <img src="{{ asset('storage/' . $fundacion->image_url) }}"
                                 alt="{{ $fundacion->name }}"
                                 class="w-full h-full object-cover">
                        @else
                            <span class="text-8xl">🏢</span>
                        @endif
                    </div>
                </div>
                <div class="w-full md:w-2/3">
                    <div class="flex items-center gap-3 mb-4">
                        <h1 class="text-4xl font-bold text-gray-900">{{ $fundacion->name }}</h1>
                        @if($fundacion->verified)
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full text-sm font-medium">
                                ✓ Verificada
                            </span>
                        @endif
                    </div>
                    
                    @if($fundacion->mission)
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Misión</h3>
                            <p class="text-gray-600 leading-relaxed">{{ $fundacion->mission }}</p>
                        </div>
                    @endif

                    @if($fundacion->description)
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Descripción</h3>
                            <p class="text-gray-600 leading-relaxed">{{ $fundacion->description }}</p>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                        @if($fundacion->address)
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $fundacion->address }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Section -->
        <div class="mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="text-3xl font-bold text-gray-900">Productos Solidarios</h2>
            
            <!-- Supplier Filter -->
            <form action="{{ route('foundations.show', $fundacion) }}" method="GET" class="flex items-center gap-3">
                <label for="supplier_id" class="text-sm font-medium text-gray-700">Filtrar por Proveedor:</label>
                <select name="supplier_id" id="supplier_id" onchange="this.form.submit()" 
                        class="rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm">
                    <option value="">Todos los proveedores</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        @if($products->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
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
                                <p class="text-sm text-gray-500 mb-2">Por: {{ $product->supplier->name ?? 'Proveedor desconocido' }}</p>
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

            <div class="mt-8">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-12 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                <p class="text-gray-500">No se encontraron productos para esta fundación con los filtros seleccionados.</p>
                @if(request('supplier_id'))
                    <a href="{{ route('foundations.show', $fundacion) }}" class="text-orange-600 hover:text-orange-700 font-medium mt-2 inline-block">
                        Limpiar filtros
                    </a>
                @endif
            </div>
        @endif
    </div>
</x-frontend.layouts.app>
