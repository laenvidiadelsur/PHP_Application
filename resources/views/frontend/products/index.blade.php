<x-frontend.layouts.app pageTitle="Productos">
    <div class="container px-6 md:px-8 mx-auto max-w-7xl py-12">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                <span class="bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
                    Nuestros Productos
                </span>
            </h1>
            <p class="text-xl text-gray-600">
                Descubre nuestra amplia gama de productos de calidad
            </p>
        </div>
        
        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <form method="GET" action="{{ route('products.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Buscar productos..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Categoría</label>
                    <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        <option value="">Todas</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ request('category') == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Proveedor</label>
                    <select name="supplier" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        <option value="">Todos</option>
                        @foreach($proveedores as $proveedor)
                            <option value="{{ $proveedor->id }}" {{ request('supplier') == $proveedor->id ? 'selected' : '' }}>
                                {{ $proveedor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white px-6 py-2 rounded-lg font-medium transition-all duration-300">
                        Filtrar
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Products Grid -->
        @if($productos->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                @foreach($productos as $producto)
                    <x-frontend.card>
                        <div class="text-center">
                            <div class="w-full h-48 bg-gradient-to-br from-orange-100 to-amber-100 rounded-lg mb-4 flex items-center justify-center">
                                <span class="text-4xl">📦</span>
                            </div>
                            <h3 class="text-lg font-bold mb-2">{{ $producto->name }}</h3>
                            <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ Str::limit($producto->description, 80) }}</p>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-2xl font-bold text-orange-600">${{ number_format($producto->price, 2) }}</span>
                                <span class="text-sm text-gray-500">Stock: {{ $producto->stock }}</span>
                            </div>
                            <div class="flex items-center justify-center gap-2 mb-4">
                                @if($producto->category)
                                    <span class="px-3 py-1 bg-orange-100 text-orange-800 rounded-full text-xs font-medium">
                                        {{ $producto->category->name }}
                                    </span>
                                @endif
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('products.show', $producto) }}" 
                                   class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg font-medium transition-all duration-300 text-center text-sm">
                                    Ver
                                </a>
                                @auth
                                    @if($producto->estado === 'activo' && $producto->stock > 0)
                                        <form action="{{ route('cart.add', $producto) }}" method="POST" class="flex-1">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" 
                                                    class="w-full bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white px-4 py-2 rounded-lg font-medium transition-all duration-300 text-sm">
                                                + Carrito
                                            </button>
                                        </form>
                                    @else
                                        <button disabled 
                                                class="w-full bg-gray-300 text-gray-500 px-4 py-2 rounded-lg font-medium text-sm cursor-not-allowed">
                                            No disponible
                                        </button>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" 
                                       class="flex-1 bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white px-4 py-2 rounded-lg font-medium transition-all duration-300 text-center text-sm">
                                        + Carrito
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </x-frontend.card>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-8">
                {{ $productos->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-xl text-gray-600">No se encontraron productos</p>
            </div>
        @endif
    </div>
</x-frontend.layouts.app>

